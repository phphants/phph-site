<?php
declare(strict_types = 1);

namespace App\Action\Account\Meetup;

use App\Service\Location\FindLocationByUuid;
use App\Service\Meetup\FindMeetupByUuidInterface;
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

final class EditMeetupAction implements MiddlewareInterface
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
     * @var FindLocationByUuid
     */
    private $findLocationByUuid;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        FindMeetupByUuidInterface $findMeetupByUuid,
        FindLocationByUuid $findLocationByUuid,
        UrlHelper $urlHelper
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->findLocationByUuid = $findLocationByUuid;
        $this->urlHelper = $urlHelper;
        $this->findMeetupByUuid = $findMeetupByUuid;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $meetup = $this->findMeetupByUuid->__invoke(Uuid::fromString($request->getAttribute('uuid')));

        $this->form->setData([
            'from' => $meetup->getFromDate()->format('Y-m-d H:i:s'),
            'to' => $meetup->getToDate()->format('Y-m-d H:i:s'),
            'location' => $meetup->getLocation()->getId(),
        ]);

        if ('POST' === strtoupper($request->getMethod())) {
            $parsedBody = $request->getParsedBody();
            $this->form->setData($parsedBody);

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($meetup, $data) {
                    $meetup->updateFromData(
                        new \DateTimeImmutable($data['from']),
                        new \DateTimeImmutable($data['to']),
                        $this->findLocationByUuid->__invoke(Uuid::fromString($data['location'])),
                        []
                    );
                });
                return new RedirectResponse($this->urlHelper->generate('account-meetup-view', [
                    'uuid' => $meetup->getId(),
                ]));
            }
        }
        return new HtmlResponse($this->templateRenderer->render('account::meetup/edit', [
            'form' => $this->form,
        ]));
    }
}
