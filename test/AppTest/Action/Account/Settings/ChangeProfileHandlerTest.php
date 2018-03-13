<?php
declare(strict_types=1);

namespace AppTest\Action\Account\Settings;

use App\Action\Account\Settings\ChangeProfileHandler;
use App\Entity\User;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Settings\ChangeProfileHandler
 */
final class ChangeProfileHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var TemplateRendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    /**
     * @var UrlHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $urlHelper;

    /**
     * @var FormInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $form;

    /**
     * @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $authenticationService;

    /**
     * @var ChangeProfileHandler
     */
    private $handler;

    public function setUp()
    {
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->form = $this->createMock(FormInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);

        $this->handler = new ChangeProfileHandler(
            $this->renderer,
            $this->form,
            $this->urlHelper,
            $this->entityManager,
            $this->authenticationService
        );
    }

    public function testGetRequestRendersTemplate(): void
    {
        $oldEmail = uniqid('oldEmail', true);
        $oldName = uniqid('oldName', true);
        $this->authenticationService->expects(self::once())
            ->method('getIdentity')
            ->willReturn(User::new(
                $oldEmail,
                $oldName,
                new PhpPasswordHash(),
                uniqid('oldPassword', true)
            ));

        $this->entityManager->expects(self::never())->method('transactional');

        $expectedContent = uniqid('expectedContent', true);
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::settings/change-profile')
            ->willReturn($expectedContent);

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::once())->method('setData')->with(['name' => $oldName, 'email' => $oldEmail]);
        $this->form->expects(self::never())->method('isValid');
        $this->form->expects(self::never())->method('getData');

        $response = $this->handler->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($expectedContent, (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate(): void
    {
        $oldEmail = uniqid('oldEmail', true);
        $oldName = uniqid('oldName', true);
        $user = User::new($oldEmail, $oldName, new PhpPasswordHash(), uniqid('oldPassword', true));
        $this->authenticationService->expects(self::once())->method('getIdentity')->willReturn($user);

        $this->entityManager->expects(self::never())->method('transactional');

        $expectedContent = uniqid('expectedContent', true);
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::settings/change-profile')
            ->willReturn($expectedContent);

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::at(0))->method('setData')->with(['name' => $oldName, 'email' => $oldEmail]);
        $this->form->expects(self::at(1))->method('setData')->with([
            'name' => '',
            'email' => '',
            'userId' => $user->id(),
        ]);
        $this->form->expects(self::once())->method('isValid')->willReturn(false);
        $this->form->expects(self::never())->method('getData');

        $response = $this->handler->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody([
                    'name' => '',
                    'email' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($expectedContent, (string)$response->getBody());
    }

    public function testValidPostRequestUpdatesPasswordAndRedirects(): void
    {
        $oldEmail = uniqid('oldEmail', true);
        $oldName = uniqid('oldName', true);
        $newEmail = uniqid('newEmail', true);
        $newName = uniqid('newName', true);
        $user = User::new($oldEmail, $oldName, new PhpPasswordHash(), uniqid('oldPassword', true));
        $this->authenticationService->expects(self::once())->method('getIdentity')->willReturn($user);

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $this->renderer->expects(self::never())->method('render');

        $settingsUrl = uniqid('/account/settings', true);
        $this->urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-settings')
            ->willReturn($settingsUrl);

        $this->form->expects(self::at(0))->method('setData')->with(['name' => $oldName, 'email' => $oldEmail]);
        $this->form->expects(self::at(1))->method('setData')->with([
            'name' => $newName,
            'email' => $newEmail,
            'userId' => $user->id(),
        ]);
        $this->form->expects(self::once())->method('isValid')->willReturn(true);
        $this->form->expects(self::once())->method('getData')->willReturn(['name' => $newName, 'email' => $newEmail]);

        $response = $this->handler->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody(['name' => $newName, 'email' => $newEmail]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($settingsUrl, $response->getHeaderLine('Location'));
    }
}
