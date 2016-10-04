<?php
declare(strict_types = 1);

namespace App\Action\Account\Speaker;

use App\Entity\Speaker;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use Zend\Stratigility\MiddlewareInterface;

final class AddSpeakerAction implements MiddlewareInterface
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
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        UrlHelper $urlHelper
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->form = $form;
        $this->entityManager = $entityManager;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        if ('POST' === strtoupper($request->getMethod())) {
            $parsedBody = $request->getParsedBody();
            $this->form->setData($parsedBody);

            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $this->entityManager->transactional(function () use ($data) {
                    $speaker = Speaker::fromNameAndTwitter(
                        $data['name'],
                        $data['twitter']
                    );
                    $this->entityManager->persist($speaker);
                    return $speaker;
                });
                return new RedirectResponse($this->urlHelper->generate('account-speakers-list'));
            }
        }
        return new HtmlResponse($this->templateRenderer->render('account::speaker/edit', [
            'title' => 'Add a new speaker',
            'form' => $this->form,
        ]));
    }
}
