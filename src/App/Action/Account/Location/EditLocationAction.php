<?php
declare(strict_types = 1);

namespace App\Action\Account\Location;

use App\Service\Location\FindLocationByUuidInterface;
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

final class EditLocationAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var FindLocationByUuidInterface
     */
    private $findLocationByUuid;

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
        FindLocationByUuidInterface $findLocationByUuid,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        UrlHelper $urlHelper
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->findLocationByUuid = $findLocationByUuid;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $location = $this->findLocationByUuid->__invoke(Uuid::fromString($request->getAttribute('uuid')));

        $this->form->setData([
            'name' => $location->getName(),
            'address' => $location->getAddress(),
            'url' => $location->getUrl(),
        ]);

        if ('POST' === strtoupper($request->getMethod())) {
            $parsedBody = $request->getParsedBody();
            $this->form->setData($parsedBody);

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($location, $data) {
                    $location->updateFromData(
                        $data['name'],
                        $data['address'],
                        $data['url']
                    );
                });
                return new RedirectResponse($this->urlHelper->generate('account-locations-list'));
            }
        }
        return new HtmlResponse($this->templateRenderer->render('account::location/edit', [
            'title' => 'Edit location',
            'form' => $this->form,
        ]));
    }
}
