<?php
declare(strict_types = 1);

namespace App\Action\Account;

use App\Service\Authentication\AuthenticationServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use Zend\Stratigility\MiddlewareInterface;

final class LoginAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var FormInterface
     */
    private $form;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        TemplateRendererInterface $templateRenderer,
        UrlHelper $urlHelper,
        FormInterface $form
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->authenticationService = $authenticationService;
        $this->urlHelper = $urlHelper;
        $this->form = $form;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        if ('POST' === strtoupper($request->getMethod())) {
            $this->form->setData($request->getParsedBody());

            if ($this->form->isValid()) {
                $data = $this->form->getData();

                if ($this->authenticationService->authenticate($data['email'], $data['password'])) {
                    return new RedirectResponse($this->urlHelper->generate('account-dashboard'));
                }

                $this->form->get('email')->setMessages(['Unable to login']);
            }
        }

        return new HtmlResponse($this->templateRenderer->render('account::login', [
            'form' => $this->form,
        ]));
    }
}
