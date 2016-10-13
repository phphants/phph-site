<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Talk;

use App\Action\Account\Talk\AddTalkAction;
use App\Entity\Meetup;
use App\Entity\Speaker;
use App\Entity\Talk;
use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\Speaker\FindSpeakerByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Talk\AddTalkAction
 */
final class AddTalkActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestRendersTemplate()
    {
        $when = '2016-12-31';

        /** @var Meetup|\PHPUnit_Framework_MockObject_MockObject $meetup */
        $meetup = $this->createMock(Meetup::class);
        $meetup->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());
        $meetup->expects(self::once())->method('getFromDate')->willReturn(new \DateTimeImmutable($when));

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::talk/edit')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::once())->method('setData')->with([
            'time' => '2016-12-31 19:30:00',
        ]);
        $form->expects(self::never())->method('isValid');
        $form->expects(self::never())->method('getData');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('transactional');
        $entityManager->expects(self::never())->method('persist');

        $findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $findMeetup->expects(self::once())->method('__invoke')->with($meetup->getId())->willReturn($meetup);

        $findSpeaker = $this->createMock(FindSpeakerByUuidInterface::class);
        $findSpeaker->expects(self::never())->method('__invoke');

        $action = new AddTalkAction($renderer, $form, $entityManager, $findMeetup, $findSpeaker, $urlHelper);
        $response = $action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('GET')
                ->withAttribute('meetup', $meetup->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $when = '2016-12-31';

        /** @var Meetup|\PHPUnit_Framework_MockObject_MockObject $meetup */
        $meetup = $this->createMock(Meetup::class);
        $meetup->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());
        $meetup->expects(self::once())->method('getFromDate')->willReturn(new \DateTimeImmutable($when));

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::talk/edit')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::at(0))->method('setData')->with([
            'time' => '2016-12-31 19:30:00',
        ]);
        $form->expects(self::at(1))->method('setData')->with([
            'time' => '',
            'speaker' => '',
            'title' => '',
            'abstract' => '',
            'youtubeId' => '',
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(false);
        $form->expects(self::never())->method('getData');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('transactional');
        $entityManager->expects(self::never())->method('persist');

        $findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $findMeetup->expects(self::once())->method('__invoke')->with($meetup->getId())->willReturn($meetup);

        $findSpeaker = $this->createMock(FindSpeakerByUuidInterface::class);
        $findSpeaker->expects(self::never())->method('__invoke');

        $action = new AddTalkAction($renderer, $form, $entityManager, $findMeetup, $findSpeaker, $urlHelper);
        $response = $action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('meetup', $meetup->getId())
                ->withParsedBody([
                    'time' => '',
                    'speaker' => '',
                    'title' => '',
                    'abstract' => '',
                    'youtubeId' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestWithSpeakerCreatesStandardTalkAndPersists()
    {
        $speaker = Speaker::fromNameAndTwitter('Foo Bar', 'foobar');

        $when = '2016-12-31';

        /** @var Meetup|\PHPUnit_Framework_MockObject_MockObject $meetup */
        $meetup = $this->createMock(Meetup::class);
        $meetup->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());
        $meetup->expects(self::once())->method('getFromDate')->willReturn(new \DateTimeImmutable($when));

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $redirectUrl = uniqid('/account/meetup/', true);
        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-meetup-view')
            ->willReturn($redirectUrl);

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::at(0))->method('setData')->with([
            'time' => '2016-12-31 19:30:00',
        ]);
        $form->expects(self::at(1))->method('setData')->with([
            'time' => '2016-11-30 19:45:00',
            'speaker' => $speaker->getId(),
            'title' => 'My great talk',
            'abstract' => 'The abstract about my fantastic talk',
            'youtubeId' => 'stVnFCyDyeY',
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(true);
        $form->expects(self::once())->method('getData')->willReturn([
            'time' => '2016-11-30 19:45:00',
            'speaker' => $speaker->getId(),
            'title' => 'My great talk',
            'abstract' => 'The abstract about my fantastic talk',
            'youtubeId' => 'stVnFCyDyeY',
        ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $entityManager->expects(self::once())->method('persist')->with(self::isInstanceOf(Talk::class));

        $findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $findMeetup->expects(self::once())->method('__invoke')->with($meetup->getId())->willReturn($meetup);

        $findSpeaker = $this->createMock(FindSpeakerByUuidInterface::class);
        $findSpeaker->expects(self::once())->method('__invoke')->with($speaker->getId())->willReturn($speaker);

        $action = new AddTalkAction($renderer, $form, $entityManager, $findMeetup, $findSpeaker, $urlHelper);
        $response = $action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('meetup', $meetup->getId())
                ->withParsedBody([
                    'time' => '2016-11-30 19:45:00',
                    'speaker' => $speaker->getId(),
                    'title' => 'My great talk',
                    'abstract' => 'The abstract about my fantastic talk',
                    'youtubeId' => 'stVnFCyDyeY',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($redirectUrl, $response->getHeaderLine('Location'));
    }

    public function testValidPostRequestWithoutSpeakerCreatesSimpleTalkAndPersists()
    {
        $when = '2016-12-31';

        /** @var Meetup|\PHPUnit_Framework_MockObject_MockObject $meetup */
        $meetup = $this->createMock(Meetup::class);
        $meetup->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());
        $meetup->expects(self::once())->method('getFromDate')->willReturn(new \DateTimeImmutable($when));

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $redirectUrl = uniqid('/account/meetup/', true);
        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-meetup-view')
            ->willReturn($redirectUrl);

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::at(0))->method('setData')->with([
            'time' => '2016-12-31 19:30:00',
        ]);
        $form->expects(self::at(1))->method('setData')->with([
            'time' => '2016-11-30 19:30:00',
            'speaker' => '',
            'title' => 'Opening speech',
            'abstract' => '',
            'youtubeId' => '',
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(true);
        $form->expects(self::once())->method('getData')->willReturn([
            'time' => '2016-11-30 19:30:00',
            'speaker' => '',
            'title' => 'Opening speech',
            'abstract' => '',
            'youtubeId' => '',
        ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $entityManager->expects(self::once())->method('persist')->with(self::isInstanceOf(Talk::class));

        $findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $findMeetup->expects(self::once())->method('__invoke')->with($meetup->getId())->willReturn($meetup);

        $findSpeaker = $this->createMock(FindSpeakerByUuidInterface::class);
        $findSpeaker->expects(self::never())->method('__invoke');

        $action = new AddTalkAction($renderer, $form, $entityManager, $findMeetup, $findSpeaker, $urlHelper);
        $response = $action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('meetup', $meetup->getId())
                ->withParsedBody([
                    'time' => '2016-11-30 19:30:00',
                    'speaker' => '',
                    'title' => 'Opening speech',
                    'abstract' => '',
                    'youtubeId' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($redirectUrl, $response->getHeaderLine('Location'));
    }
}
