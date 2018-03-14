<?php
declare(strict_types=1);

namespace AppTest\Action\Account\Settings;

use App\Action\Account\Settings\ChangePassword;
use App\Entity\User;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\User\PasswordHashInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Settings\ChangePassword
 */
final class ChangePasswordTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $hasher;

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
     * @var ChangePassword
     */
    private $action;

    public function setUp()
    {
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->form = $this->createMock(FormInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $this->hasher = $this->createMock(PasswordHashInterface::class);

        $this->action = new ChangePassword(
            $this->renderer,
            $this->form,
            $this->urlHelper,
            $this->entityManager,
            $this->authenticationService,
            $this->hasher
        );
    }

    public function testGetRequestRendersTemplate(): void
    {
        $this->entityManager->expects(self::never())->method('transactional');

        $expectedContent = uniqid('expectedContent', true);
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::settings/change-password')
            ->willReturn($expectedContent);

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::never())->method('setData');
        $this->form->expects(self::never())->method('isValid');
        $this->form->expects(self::never())->method('getData');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($expectedContent, (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate(): void
    {
        $this->entityManager->expects(self::never())->method('transactional');

        $expectedContent = uniqid('expectedContent', true);
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::settings/change-password')
            ->willReturn($expectedContent);

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::once())->method('setData')->with([
            'password' => '',
            'confirmPassword' => '',
        ]);
        $this->form->expects(self::once())->method('isValid')->willReturn(false);
        $this->form->expects(self::never())->method('getData');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody([
                    'password' => '',
                    'confirmPassword' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($expectedContent, (string)$response->getBody());
    }


    public function testValidPostRequestUpdatesPasswordAndRedirects(): void
    {
        $password = uniqid('password', true);
        $hash = uniqid('hash', true);
        $data = [
            'password' => $password,
            'confirmPassword' => $password,
        ];

        $this->authenticationService->expects(self::once())
            ->method('getIdentity')
            ->willReturn(User::new(
                uniqid('email', true),
                uniqid('name', true),
                new PhpPasswordHash(),
                uniqid('oldPassword', true)
            ));

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $this->hasher->expects(self::once())->method('hash')->with($password)->willReturn($hash);

        $this->renderer->expects(self::never())->method('render');

        $settingsUrl = uniqid('/account/settings', true);
        $this->urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-settings')
            ->willReturn($settingsUrl);

        $this->form->expects(self::once())->method('setData')->with($data);
        $this->form->expects(self::once())->method('isValid')->willReturn(true);
        $this->form->expects(self::once())->method('getData')->willReturn($data);

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody($data),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($settingsUrl, $response->getHeaderLine('Location'));
    }
}
