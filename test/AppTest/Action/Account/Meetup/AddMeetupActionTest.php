<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Meetup;

use App\Action\Account\Meetup\AddMeetupAction;
use App\Entity\Location;
use App\Service\Location\FindLocationByUuid;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Meetup\AddMeetupAction
 */
final class AddMeetupActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestRendersTemplate()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::meetup/add')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::never())->method('setData');
        $form->expects(self::never())->method('isValid');
        $form->expects(self::never())->method('getData');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('transactional');

        $findLocation = $this->createMock(FindLocationByUuid::class);
        $findLocation->expects(self::never())->method('__invoke');

        $response = (new AddMeetupAction($renderer, $form, $entityManager, $findLocation, $urlHelper))->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::meetup/add')->willReturn('content...');

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

        $findLocation = $this->createMock(FindLocationByUuid::class);
        $findLocation->expects(self::never())->method('__invoke');

        $response = (new AddMeetupAction($renderer, $form, $entityManager, $findLocation, $urlHelper))->__invoke(
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

    public function testValidPostRequestCreatesMeetupAndPersists()
    {
        $location = Location::fromNameAddressAndUrl('foo', 'bar', 'baz');

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-meetup-view')
            ->willReturn('/account/meetup/view');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::once())->method('setData')->with([
            'from' => '2015-01-01 18:00',
            'to' => '2015-01-01 23:00',
            'location' => $location->getId(),
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(true);
        $form->expects(self::once())->method('getData')->willReturn([
            'from' => '2015-01-01 18:00',
            'to' => '2015-01-01 23:00',
            'location' => $location->getId(),
        ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $findLocation = $this->createMock(FindLocationByUuid::class);
        $findLocation->expects(self::once())->method('__invoke')->with($location->getId())->willReturn($location);

        $response = (new AddMeetupAction($renderer, $form, $entityManager, $findLocation, $urlHelper))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody([
                    'from' => '2015-01-01 18:00',
                    'to' => '2015-01-01 23:00',
                    'location' => $location->getId(),
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/meetup/view', $response->getHeaderLine('Location'));
    }
}
