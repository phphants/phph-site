<?php
declare(strict_types = 1);

namespace App\Action;

use App\Service\MeetupsServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class MeetupsAction implements MiddlewareInterface
{
    /**
     * @var MeetupsServiceInterface
     */
    private $meetupsService;

    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    public function __construct(MeetupsServiceInterface $meetupsService, TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
        $this->meetupsService = $meetupsService;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        return new HtmlResponse($this->templateRenderer->render(
            'app::meetups',
            [
                'futureMeetups' => $this->meetupsService->getFutureMeetups(),
                'pastMeetups' => $this->meetupsService->getPastMeetups(),
            ]
        ));
    }
}
