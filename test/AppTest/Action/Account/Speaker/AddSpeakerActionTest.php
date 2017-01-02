<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Speaker;

use App\Action\Account\Speaker\AddSpeakerAction;
use App\Entity\Speaker;
use App\Form\Account\SpeakerForm;
use App\Service\Speaker\MoveSpeakerHeadshotInterface;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\UploadedFile;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Speaker\AddSpeakerAction
 */
final class AddSpeakerActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestRendersTemplate()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::speaker/edit')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $form = $this->createMock(SpeakerForm::class);
        $form->expects(self::never())->method('setDataWithUploadedFiles');
        $form->expects(self::never())->method('isValid');
        $form->expects(self::never())->method('getData');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('transactional');

        $moveSpeakerHeadshot = $this->createMock(MoveSpeakerHeadshotInterface::class);
        $moveSpeakerHeadshot->expects(self::never())->method('__invoke');

        $response = (new AddSpeakerAction($renderer, $form, $entityManager, $urlHelper, $moveSpeakerHeadshot))
            ->__invoke(
                (new ServerRequest(['/']))->withMethod('GET'),
                new Response()
            );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::speaker/edit')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $request = (new ServerRequest(['/']))
            ->withMethod('post')
            ->withParsedBody([
                'name' => '',
                'twitter' => '',
                'biography' => '',
            ]);

        $form = $this->createMock(SpeakerForm::class);
        $form->expects(self::once())
            ->method('setDataWithUploadedFiles')
            ->with(
                [
                    'name' => '',
                    'twitter' => '',
                    'biography' => '',
                ],
                []
            );
        $form->expects(self::once())->method('isValid')->willReturn(false);
        $form->expects(self::never())->method('getData');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('transactional');

        $moveSpeakerHeadshot = $this->createMock(MoveSpeakerHeadshotInterface::class);
        $moveSpeakerHeadshot->expects(self::never())->method('__invoke');

        $response = (new AddSpeakerAction($renderer, $form, $entityManager, $urlHelper, $moveSpeakerHeadshot))
            ->__invoke(
                $request,
                new Response()
            );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestCreatesSpeakerAndPersists()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-speakers-list')
            ->willReturn('/account/speakers');

        $tempFile = uniqid('/tmp/test-file', true);
        $uploadedFile = new UploadedFile($tempFile, 123, 0);

        $request = (new ServerRequest(['/']))
            ->withMethod('post')
            ->withParsedBody([
                'name' => 'Foo Bar',
                'twitter' => 'foobar',
                'biography' => 'Bio text about speaker',
            ])
            ->withUploadedFiles([
                'imageFilename' => $uploadedFile,
            ]);

        $form = $this->createMock(SpeakerForm::class);
        $form->expects(self::once())
            ->method('setDataWithUploadedFiles')
            ->with(
                [
                    'name' => 'Foo Bar',
                    'twitter' => 'foobar',
                    'biography' => 'Bio text about speaker',
                ],
                [
                    'imageFilename' => $uploadedFile,
                ]
            );
        $form->expects(self::once())->method('isValid')->willReturn(true);
        $form->expects(self::once())->method('getData')->willReturn([
            'name' => 'Foo Bar',
            'twitter' => 'foobar',
            'biography' => 'Bio text about speaker',
            'imageFilename' => [
                'tmp_name' => $tempFile,
            ],
        ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $entityManager->expects(self::once())->method('persist')->with(self::isInstanceOf(Speaker::class));

        $moveSpeakerHeadshot = $this->createMock(MoveSpeakerHeadshotInterface::class);
        $moveSpeakerHeadshot->expects(self::once())->method('__invoke')
            ->with($uploadedFile);

        $response = (new AddSpeakerAction($renderer, $form, $entityManager, $urlHelper, $moveSpeakerHeadshot))
            ->__invoke(
                $request,
                new Response()
            );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/speakers', $response->getHeaderLine('Location'));
    }
}
