<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Location;

use App\Action\Account\Location\ListLocationsAction;
use App\Entity\Location;
use App\Service\Location\GetAllLocationsInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\Location\ListLocationsAction
 */
final class ListLocationsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodDisplaysLocations()
    {
        $locations = [
            $this->createMock(Location::class),
            $this->createMock(Location::class),
        ];

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::location/list', [
            'locations' => $locations,
        ])->willReturn('content...');

        $getAllLocations = $this->createMock(GetAllLocationsInterface::class);
        $getAllLocations->expects(self::once())->method('__invoke')->with()->willReturn($locations);

        $response = (new ListLocationsAction($renderer, $getAllLocations))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}
