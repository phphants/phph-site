<?php
declare(strict_types = 1);

namespace App\Action\Account\Talk;

use App\Service\Talk\FindTalkByUuidInterface;
use App\Service\Speaker\FindSpeakerByUuidInterface;
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

final class EditTalkAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FindTalkByUuidInterface
     */
    private $findTalkByUuid;

    /**
     * @var FindSpeakerByUuidInterface
     */
    private $findSpeakerByUuid;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        FindTalkByUuidInterface $findTalkByUuid,
        FindSpeakerByUuidInterface $findSpeakerByUuid,
        UrlHelper $urlHelper
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->findTalkByUuid = $findTalkByUuid;
        $this->findSpeakerByUuid = $findSpeakerByUuid;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $talk = $this->findTalkByUuid->__invoke(Uuid::fromString($request->getAttribute('uuid')));

        $this->form->setData([
            'time' => $talk->getTime()->format('Y-m-d H:i:s'),
            'speaker' => null !== $talk->getSpeaker() ? $talk->getSpeaker()->getId() : '',
            'title' => $talk->getTitle(),
            'abstract' => $talk->getAbstract(),
        ]);

        if ('POST' === strtoupper($request->getMethod())) {
            $this->form->setData($request->getParsedBody());

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($talk, $data) {
                    $speaker = (string)$data['speaker'] !== ''
                        ? $this->findSpeakerByUuid->__invoke(Uuid::fromString($data['speaker']))
                        : null;

                    $talk->updateFromData(
                        new \DateTimeImmutable($data['time']),
                        $data['title'],
                        $data['abstract'],
                        $speaker
                    );
                });
                return new RedirectResponse($this->urlHelper->generate('account-meetup-view', [
                    'uuid' => $talk->getMeetup()->getId(),
                ]));
            }
        }
        return new HtmlResponse($this->templateRenderer->render('account::talk/edit', [
            'title' => 'Update talk',
            'form' => $this->form,
        ]));
    }
}
