<?php
declare(strict_types = 1);

namespace App\Action\Account\Meetup;

use App\Service\Meetup\GetAllMeetupsInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ListMeetupsAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var GetAllMeetupsInterface
     */
    private $meetups;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        GetAllMeetupsInterface $meetups
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->meetups = $meetups;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        return new HtmlResponse($this->templateRenderer->render('account::meetup/list', [
            'meetups' => $this->meetups->__invoke(),
        ]));
    }
}
