<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Speaker;

use App\Action\Account\Speaker\EditSpeakerAction;
use App\Entity\Speaker;
use App\Service\Speaker\FindSpeakerByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Speaker\EditSpeakerAction
 */
final class EditSpeakerActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $form;

    /**
     * @var Speaker
     */
    private $speaker;

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
     * @var FindSpeakerByUuidInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findSpeaker;

    /**
     * @var EditSpeakerAction
     */
    private $action;

    public function setUp()
    {
        $this->speaker = Speaker::fromNameAndTwitter(
            'Foo Bar',
            'foobar'
        );

        $this->form = $this->createMock(FormInterface::class);
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->findSpeaker = $this->createMock(FindSpeakerByUuidInterface::class);
        $this->findSpeaker->expects(self::once())
            ->method('__invoke')
            ->with($this->speaker->getId())
            ->willReturn($this->speaker);

        $this->action = new EditSpeakerAction(
            $this->renderer,
            $this->findSpeaker,
            $this->form,
            $this->entityManager,
            $this->urlHelper
        );
    }

    public function testGetRequestRendersTemplate()
    {
        $this->form->expects(self::once())->method('setData');
        $this->form->expects(self::never())->method('isValid');
        $this->form->expects(self::never())->method('getData');

        $this->renderer->expects(self::once())->method('render')->with('account::speaker/edit', [
            'title' => 'Edit speaker',
            'form' => $this->form,
        ])->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->entityManager->expects(self::never())->method('transactional');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('GET')
                ->withAttribute('uuid', $this->speaker->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::speaker/edit')
            ->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(false);
        $this->form->expects(self::never())->method('getData');

        $this->entityManager->expects(self::never())->method('transactional');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->speaker->getId())
                ->withParsedBody([
                    'name' => '',
                    'twitter' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestUpdatesSpeaker()
    {
        $this->renderer->expects(self::never())->method('render');

        $this->urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-speakers-list')
            ->willReturn('/account/speakers');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(true);
        $this->form->expects(self::once())->method('getData')->willReturn([
            'name' => 'Speaker Name',
            'twitter' => 'SpeakerTwitter',
        ]);

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->speaker->getId())
                ->withParsedBody([
                    'name' => 'Speaker Name',
                    'twitter' => 'SpeakerTwitter',
                ]),
            new Response()
        );

        self::assertSame('Speaker Name', $this->speaker->getFullName());
        self::assertSame('SpeakerTwitter', $this->speaker->getTwitterHandle());

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/speakers', $response->getHeaderLine('Location'));
    }
}
