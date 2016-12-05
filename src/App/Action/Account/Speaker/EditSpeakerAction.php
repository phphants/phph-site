<?php
declare(strict_types = 1);

namespace App\Action\Account\Speaker;

use App\Entity\Speaker;
use App\Form\Account\SpeakerForm;
use App\Service\Speaker\FindSpeakerByUuidInterface;
use App\Service\Speaker\MoveSpeakerHeadshotInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use Zend\Stratigility\MiddlewareInterface;

final class EditSpeakerAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var FindSpeakerByUuidInterface
     */
    private $findSpeakerByUuid;

    /**
     * @var FormInterface|SpeakerForm
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
        FindSpeakerByUuidInterface $findSpeakerByUuid,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        UrlHelper $urlHelper,
        MoveSpeakerHeadshotInterface $moveSpeakerHeadshot
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->findSpeakerByUuid = $findSpeakerByUuid;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->urlHelper = $urlHelper;
        $this->moveSpeakerHeadshot = $moveSpeakerHeadshot;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        /** @var Speaker $speaker */
        $speaker = $this->findSpeakerByUuid->__invoke(Uuid::fromString($request->getAttribute('uuid')));

        $this->form->setData([
            'name' => $speaker->getFullName(),
            'twitter' => $speaker->getTwitterHandle(),
            'biography' => $speaker->getBiography(),
        ]);

        if ('POST' === strtoupper($request->getMethod())) {
            $this->form->setDataWithUploadedFiles($request->getParsedBody(), $request->getUploadedFiles());

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($speaker, $data, $request) {
                    $speaker->updateFromData(
                        $data['name'],
                        $data['twitter'],
                        $data['biography'],
                        null !== $data['imageFilename']['tmp_name']
                            ? $this->moveSpeakerHeadshot->__invoke($request->getUploadedFiles()['imageFilename'])
                            : $speaker->getImageFilename()
                    );
                });
                return new RedirectResponse($this->urlHelper->generate('account-speakers-list'));
            }
        }
        return new HtmlResponse($this->templateRenderer->render('account::speaker/edit', [
            'title' => 'Edit speaker',
            'form' => $this->form,
        ]));
    }
}
