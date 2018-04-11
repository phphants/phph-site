<?php
declare(strict_types = 1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class IndexAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        $currentDate = strtotime(date('U'));
        $nextMeet    = strtotime('second wednesday of '.date('M'));
        if ($currentDate >= $nextMeet) {
            $nextMeet = strtotime('second wednesday of '.date('M', strtotime("+1 month")));
        }

        return new HtmlResponse(
            $this->templateRenderer->render(
                'app::index',
                [
                    'nextMeet' => date('l jS \of F Y', $nextMeet),
                ]
            )
        );
    }
}
