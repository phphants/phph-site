<?php
declare(strict_types = 1);

namespace App\Action\Account\Speaker;

use App\Entity\Speaker;
use App\Form\Account\SpeakerForm;
use App\Service\Speaker\MoveSpeakerHeadshotInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class AddSpeakerAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var SpeakerForm
     */
    private $form;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var MoveSpeakerHeadshotInterface
     */
    private $moveSpeakerHeadshot;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        SpeakerForm $form,
        EntityManagerInterface $entityManager,
        UrlHelper $urlHelper,
        MoveSpeakerHeadshotInterface $moveSpeakerHeadshot
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->urlHelper = $urlHelper;
        $this->moveSpeakerHeadshot = $moveSpeakerHeadshot;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        if ('POST' === strtoupper($request->getMethod())) {
            $this->form->setDataWithUploadedFiles($request->getParsedBody(), $request->getUploadedFiles());

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($data, $request) {
                    $speaker = Speaker::fromNameAndTwitter(
                        $data['name'],
                        $data['twitter'],
                        $data['biography'],
                        null !== $data['imageFilename']['tmp_name']
                            ? $this->moveSpeakerHeadshot->__invoke($request->getUploadedFiles()['imageFilename'])
                            : null
                    );
                    $this->entityManager->persist($speaker);
                    return $speaker;
                });
                return new RedirectResponse($this->urlHelper->generate('account-speakers-list'));
            }
        }
        return new HtmlResponse($this->templateRenderer->render('account::speaker/edit', [
            'title' => 'Add a new speaker',
            'form' => $this->form,
            'speaker' => null,
        ]));
    }
}
