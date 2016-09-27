<?php
declare(strict_types = 1);

namespace App\Action;

use App\Service\Video\GetAllVideosInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class VideosAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var GetAllVideosInterface
     */
    private $videos;

    public function __construct(TemplateRendererInterface $templateRenderer, GetAllVideosInterface $videos)
    {
        $this->templateRenderer = $templateRenderer;
        $this->videos = $videos;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        return new HtmlResponse($this->templateRenderer->render(
            'app::videos',
            [
                'videos' => $this->videos->__invoke(),
            ]
        ));
    }
}
