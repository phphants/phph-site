<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\SubscribeAction;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * @covers \App\Action\SubscribeAction
 */
final class SubscribeActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersView()
    {
        $response = (new SubscribeAction())->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('http://eepurl.com/DaINX', $response->getHeaderLine('Location'));
    }
}
