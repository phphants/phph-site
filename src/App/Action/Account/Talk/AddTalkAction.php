<?php
declare(strict_types = 1);

namespace App\Action\Account\Talk;

use App\Entity\Talk;
use App\Service\Meetup\FindMeetupByUuidInterface;
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

final class AddTalkAction implements MiddlewareInterface
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
     * @var FindMeetupByUuidInterface
     */
    private $findMeetupByUuid;

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
        FindMeetupByUuidInterface $findMeetupByUuid,
        FindSpeakerByUuidInterface $findSpeakerByUuid,
        UrlHelper $urlHelper
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->findMeetupByUuid = $findMeetupByUuid;
        $this->findSpeakerByUuid = $findSpeakerByUuid;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $meetup = $this->findMeetupByUuid->__invoke(Uuid::fromString($request->getAttribute('meetup')));

        $this->form->setData([
            'time' => $meetup->getFromDate()->format('Y-m-d') . ' 19:30:00',
        ]);

        if ('POST' === strtoupper($request->getMethod())) {
            $this->form->setData($request->getParsedBody());

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($meetup, $data) {
                    $talk = Talk::fromStandardTalk(
                        $meetup,
                        new \DateTimeImmutable($data['time']),
                        $this->findSpeakerByUuid->__invoke(Uuid::fromString($data['speaker'])),
                        $data['title'],
                        $data['abstract']
                    );
                    $this->entityManager->persist($talk);
                    return $talk;
                });
                return new RedirectResponse($this->urlHelper->generate('account-meetup-view', [
                    'uuid' => $meetup->getId(),
                ]));
            }
        }
        return new HtmlResponse($this->templateRenderer->render('account::talk/edit', [
            'title' => 'Add a new talk',
            'form' => $this->form,
        ]));
    }
}
