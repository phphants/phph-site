<?php
declare(strict_types=1);

namespace App\Action\Account\Settings;

use App\Service\Authentication\AuthenticationServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ChangeProfileHandler implements MiddlewareInterface
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
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FormInterface $form,
        UrlHelper $urlHelper,
        EntityManagerInterface $entityManager,
        AuthenticationServiceInterface $authenticationService
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->form = $form;
        $this->urlHelper = $urlHelper;
        $this->entityManager = $entityManager;
        $this->authenticationService = $authenticationService;
    }

    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException
     * @throws \App\Service\Authentication\Exception\NotAuthenticated
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $user = $this->authenticationService->getIdentity();
        $this->form->setData([
            'name' => $user->displayName(),
            'email' => $user->getEmail(),
        ]);

        if ('POST' === strtoupper($request->getMethod())) {
            // Note, user ID is *not* injected from POST, so merge it in (avoids client-side invalid data injection)
            $this->form->setData(array_merge($request->getParsedBody(), ['userId' => $user->id()]));

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($user, $data) {
                    $user->changeProfile($data['name'], $data['email']);
                });
                // @todo add in some kind of feedback to the user, maybe use zend-expressive-flash
                return new RedirectResponse($this->urlHelper->generate('account-settings'));
            }
        }

        return new HtmlResponse($this->templateRenderer->render('account::settings/change-profile', [
            'form' => $this->form,
        ]));
    }
}
