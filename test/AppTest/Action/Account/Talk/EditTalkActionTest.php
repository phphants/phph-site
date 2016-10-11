<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Talk;

use App\Action\Account\Talk\EditTalkAction;
use App\Entity\Location;
use App\Entity\Speaker;
use App\Entity\Talk;
use App\Service\Speaker\FindSpeakerByUuidInterface;
use App\Service\Talk\FindTalkByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Talk\EditTalkAction
 */
final class EditTalkActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $form;

    /**
     * @var Talk|\PHPUnit_Framework_MockObject_MockObject
     */
    private $talk;

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
     * @var FindTalkByUuidInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findTalk;

    /**
     * @var FindSpeakerByUuidInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findSpeaker;

    /**
     * @var EditTalkAction
     */
    private $action;

    public function setUp()
    {
        $this->talk = $this->createMock(Talk::class);
        $this->talk->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());

        $this->form = $this->createMock(FormInterface::class);
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->findTalk = $this->createMock(FindTalkByUuidInterface::class);
        $this->findTalk->expects(self::once())
            ->method('__invoke')
            ->with($this->talk->getId())
            ->willReturn($this->talk);
        $this->findSpeaker = $this->createMock(FindSpeakerByUuidInterface::class);

        $this->action = new EditTalkAction(
            $this->renderer,
            $this->form,
            $this->entityManager,
            $this->findTalk,
            $this->findSpeaker,
            $this->urlHelper
        );
    }

    public function testGetRequestRendersTemplate()
    {
        $this->form->expects(self::once())->method('setData');
        $this->form->expects(self::never())->method('isValid');
        $this->form->expects(self::never())->method('getData');

        $this->renderer->expects(self::once())->method('render')->with('account::talk/edit', [
            'title' => 'Update talk',
            'form' => $this->form,
        ])->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->entityManager->expects(self::never())->method('transactional');

        $this->findSpeaker->expects(self::never())->method('__invoke');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('GET')
                ->withAttribute('uuid', $this->talk->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::talk/edit')
            ->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(false);
        $this->form->expects(self::never())->method('getData');

        $this->entityManager->expects(self::never())->method('transactional');

        $this->findSpeaker->expects(self::never())->method('__invoke');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->talk->getId())
                ->withParsedBody([
                    'time' => '',
                    'speaker' => '',
                    'title' => '',
                    'abstract' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestCreatesTalkAndPersists()
    {
        $speaker = Speaker::fromNameAndTwitter('Foo Bar', 'foobar');

        $this->renderer->expects(self::never())->method('render');

        $this->urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-meetup-view')
            ->willReturn('/account/meetup/view');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(true);
        $this->form->expects(self::once())->method('getData')->willReturn([
            'time' => '2016-01-01 19:30',
            'speaker' => $speaker->getId(),
            'title' => 'A Fantastic Talk',
            'abstract' => 'Some abstract text about this talk',
        ]);

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $this->findSpeaker->expects(self::once())->method('__invoke')->with($speaker->getId())->willReturn($speaker);

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->talk->getId())
                ->withParsedBody([
                    'time' => '2016-01-01 19:30',
                    'speaker' => $speaker->getId(),
                    'title' => 'A Fantastic Talk',
                    'abstract' => 'Some abstract text about this talk',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/meetup/view', $response->getHeaderLine('Location'));
    }
}
