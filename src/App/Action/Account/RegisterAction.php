<?php
declare(strict_types = 1);

namespace App\Action\Account;

use App\Entity\User;
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

final class RegisterAction implements MiddlewareInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var PasswordHashInterface
     */
    private $passwordAlgorithm;

    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var FormInterface
     */
    private $form;

    public function __construct(
        EntityManagerInterface $entityManager,
        PasswordHashInterface $passwordAlgorithm,
        TemplateRendererInterface $templateRenderer,
        UrlHelper $urlHelper,
        FormInterface $form
    ) {
        $this->entityManager = $entityManager;
        $this->passwordAlgorithm = $passwordAlgorithm;
        $this->templateRenderer = $templateRenderer;
        $this->urlHelper = $urlHelper;
        $this->form = $form;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        if ('POST' === strtoupper($request->getMethod())) {
            $this->form->setData($request->getParsedBody());

            if ($this->form->isValid()) {
                $data = $this->form->getData();

                $this->entityManager->transactional(function () use ($data) {
                    $this->entityManager->persist(
                        User::new($data['email'], $data['name'], $this->passwordAlgorithm, $data['password'])
                    );
                });
                return new RedirectResponse($this->urlHelper->generate('account-login'));
            }
        }

        return new HtmlResponse($this->templateRenderer->render('account::register', [
            'form' => $this->form,
        ]));
    }
}
