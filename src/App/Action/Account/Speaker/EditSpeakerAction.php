<?php
declare(strict_types = 1);

namespace App\Action\Account\Speaker;

use App\Entity\Speaker;
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
     * @var FormInterface
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

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FindSpeakerByUuidInterface $findSpeakerByUuid,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        UrlHelper $urlHelper
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->findSpeakerByUuid = $findSpeakerByUuid;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        /** @var Speaker $speaker */
        $speaker = $this->findSpeakerByUuid->__invoke(Uuid::fromString($request->getAttribute('uuid')));

        $this->form->setData([
            'name' => $speaker->getFullName(),
            'twitter' => $speaker->getTwitterHandle(),
        ]);

        if ('POST' === strtoupper($request->getMethod())) {
            $parsedBody = $request->getParsedBody();
            $this->form->setData($parsedBody);

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($speaker, $data) {
                    $speaker->updateFromData(
                        $data['name'],
                        $data['twitter']
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
