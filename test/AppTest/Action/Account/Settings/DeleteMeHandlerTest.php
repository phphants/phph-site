<?php
declare(strict_types=1);

namespace AppTest\Action\Account\Settings;

use App\Action\Account\Settings\DeleteMeHandler;
use App\Entity\User;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\Settings\DeleteMeHandler
 */
final class DeleteMeHandlerTest extends \PHPUnit_Framework_TestCase
{
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
     * @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $authenticationService;

    /**
     * @var DeleteMeHandler
     */
    private $handler;

    public function setUp(): void
    {
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);

        $this->handler = new DeleteMeHandler(
            $this->renderer,
            $this->urlHelper,
            $this->entityManager,
            $this->authenticationService
        );
    }

    public function testGetRequestRendersTemplate(): void
    {
        $this->entityManager->expects(self::never())->method('transactional');
        $this->entityManager->expects(self::never())->method('remove');

        $this->authenticationService->expects(self::never())->method('getIdentity');
        $this->authenticationService->expects(self::never())->method('clearIdentity');

        $expectedContent = uniqid('expectedContent', true);
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::settings/confirm-delete-me')
            ->willReturn($expectedContent);

        $this->urlHelper->expects(self::never())->method('generate');

        $response = $this->handler->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($expectedContent, (string)$response->getBody());
    }

    public function testPostWillLogOutUserAndRemoveEntity(): void
    {
        $user = User::new(uniqid('email', true), uniqid('name', true), new PhpPasswordHash(), uniqid('password', true));

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $this->entityManager->expects(self::once())->method('remove')->with($user);

        $this->authenticationService->expects(self::once())->method('getIdentity')->willReturn($user);
        $this->authenticationService->expects(self::once())->method('clearIdentity');

        $this->renderer->expects(self::never())->method('render');

        $expectedUrl = uniqid('url', true);
        $this->urlHelper->expects(self::once())->method('generate')->with('home')->willReturn($expectedUrl);

        $response = $this->handler->__invoke(
            (new ServerRequest(['/']))->withMethod('POST'),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($expectedUrl, (string)$response->getHeaderLine('Location'));
    }
}
