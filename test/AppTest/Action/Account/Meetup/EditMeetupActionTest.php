<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Meetup;

use App\Action\Account\Meetup\EditMeetupAction;
use App\Entity\Location;
use App\Entity\Meetup;
use App\Service\Location\FindLocationByUuid;
use App\Service\Meetup\FindMeetupByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Meetup\EditMeetupAction
 */
final class EditMeetupActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $form;

    /**
     * @var Meetup|\PHPUnit_Framework_MockObject_MockObject
     */
    private $meetup;

    /**
     * @var TemplateRendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    /**
     * @var UrlHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $urlHelper;

    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var FindMeetupByUuidInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findMeetup;

    /**
     * @var FindLocationByUuid|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findLocation;

    /**
     * @var EditMeetupAction
     */
    private $action;

    public function setUp()
    {
        $this->meetup = $this->createMock(Meetup::class);
        $this->meetup->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());

        $this->form = $this->createMock(FormInterface::class);
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $this->findMeetup->expects(self::once())
            ->method('__invoke')
            ->with($this->meetup->getId())
            ->willReturn($this->meetup);
        $this->findLocation = $this->createMock(FindLocationByUuid::class);

        $this->action = new EditMeetupAction(
            $this->renderer,
            $this->form,
            $this->entityManager,
            $this->findMeetup,
            $this->findLocation,
            $this->urlHelper
        );
    }

    public function testGetRequestRendersTemplate()
    {
        $this->form->expects(self::once())->method('setData');
        $this->form->expects(self::never())->method('isValid');
        $this->form->expects(self::never())->method('getData');

        $this->renderer->expects(self::once())->method('render')->with('account::meetup/edit', [
            'title' => 'Edit meetup',
            'form' => $this->form,
        ])->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->entityManager->expects(self::never())->method('transactional');

        $this->findLocation->expects(self::never())->method('__invoke');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('GET')
                ->withAttribute('uuid', $this->meetup->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::meetup/edit')
            ->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(false);
        $this->form->expects(self::never())->method('getData');

        $this->entityManager->expects(self::never())->method('transactional');

        $this->findLocation->expects(self::never())->method('__invoke');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->meetup->getId())
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

        $this->renderer->expects(self::never())->method('render');

        $this->urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-meetup-view')
            ->willReturn('/account/meetup/view');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(true);
        $this->form->expects(self::once())->method('getData')->willReturn([
            'from' => '2015-01-01 18:00',
            'to' => '2015-01-01 23:00',
            'location' => $location->getId(),
        ]);

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $this->findLocation->expects(self::once())->method('__invoke')->with($location->getId())->willReturn($location);

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->meetup->getId())
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
