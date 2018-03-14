<?php
declare(strict_types=1);

namespace App\Action\Account\Settings;

use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\User\PasswordHashInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ChangePassword implements MiddlewareInterface
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

    /**
     * @var PasswordHashInterface
     */
    private $passwordAlgorithm;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FormInterface $form,
        UrlHelper $urlHelper,
        EntityManagerInterface $entityManager,
        AuthenticationServiceInterface $authenticationService,
        PasswordHashInterface $passwordAlgorithm
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->form = $form;
        $this->urlHelper = $urlHelper;
        $this->entityManager = $entityManager;
        $this->authenticationService = $authenticationService;
        $this->passwordAlgorithm = $passwordAlgorithm;
    }

    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException
     * @throws \App\Service\Authentication\Exception\NotAuthenticated
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        if ('POST' === strtoupper($request->getMethod())) {
            $this->form->setData($request->getParsedBody());

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($data) {
                    $user = $this->authenticationService->getIdentity();
                    $user->changePassword($this->passwordAlgorithm, $data['password']);
                });
                // @todo add in some kind of feedback to the user, maybe use zend-expressive-flash
                return new RedirectResponse($this->urlHelper->generate('account-settings'));
            }
        }

        return new HtmlResponse($this->templateRenderer->render('account::settings/change-password', [
            'form' => $this->form,
        ]));
    }
}
