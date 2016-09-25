<?php
declare(strict_types = 1);

namespace App\Action\Account\Location;

use App\Service\Location\GetAllLocationsInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ListLocationsAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var GetAllLocationsInterface
     */
    private $locations;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        GetAllLocationsInterface $locations
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->locations = $locations;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        return new HtmlResponse($this->templateRenderer->render('account::location/list', [
            'locations' => $this->locations->__invoke(),
        ]));
    }
}
