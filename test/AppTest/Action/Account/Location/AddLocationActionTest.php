<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Location;

use App\Action\Account\Location\AddLocationAction;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Location\AddLocationAction
 */
final class AddLocationActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestRendersTemplate()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::location/edit')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::never())->method('setData');
        $form->expects(self::never())->method('isValid');
        $form->expects(self::never())->method('getData');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('transactional');

        $response = (new AddLocationAction($renderer, $form, $entityManager, $urlHelper))->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::location/edit')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::once())->method('setData')->with([
            'from' => '',
            'to' => '',
            'location' => '',
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(false);
        $form->expects(self::never())->method('getData');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('transactional');

        $response = (new AddLocationAction($renderer, $form, $entityManager, $urlHelper))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody([
                    'from' => '',
                    'to' => '',
                    'location' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestCreatesLocationAndPersists()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-locations-list')
            ->willReturn('/account/locations');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::once())->method('setData')->with([
            'name' => 'A Venue Name',
            'address' => 'Venue Street, Venue Town',
            'url' => 'https://a-great-venue.com',
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(true);
        $form->expects(self::once())->method('getData')->willReturn([
            'name' => 'A Venue Name',
            'address' => 'Venue Street, Venue Town',
            'url' => 'https://a-great-venue.com',
        ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $entityManager->expects(self::once())->method('persist')->with(self::isInstanceOf(Location::class));

        $response = (new AddLocationAction($renderer, $form, $entityManager, $urlHelper))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody([
                    'name' => 'A Venue Name',
                    'address' => 'Venue Street, Venue Town',
                    'url' => 'https://a-great-venue.com',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/locations', $response->getHeaderLine('Location'));
    }
}
