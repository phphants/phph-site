<?php
declare(strict_types = 1);

namespace App\Action\Account\Speaker;

use App\Service\Speaker\GetAllSpeakersInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ListSpeakersAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var GetAllSpeakersInterface
     */
    private $speakers;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        GetAllSpeakersInterface $speakers
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->speakers = $speakers;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        return new HtmlResponse($this->templateRenderer->render('account::speaker/list', [
            'speakers' => $this->speakers->__invoke(),
        ]));
    }
}
