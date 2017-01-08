<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\Account\RegisterAction;
use App\Entity\User;
use App\Service\Authorization\Role\AttendeeRole;
use App\Service\User\PasswordHashInterface;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\Element\Text;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\RegisterAction
 */
final class RegisterActionTest extends \PHPUnit_Framework_TestCase
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
     * @var RegisterAction
     */
    private $action;

    public function setUp()
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->hasher = $this->createMock(PasswordHashInterface::class);
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->form = $this->createMock(FormInterface::class);

        $this->action = new RegisterAction(
            $this->entityManager,
            $this->hasher,
            $this->renderer,
            $this->urlHelper,
            $this->form
        );
    }

    public function testGetRequestRendersTemplate()
    {
        $this->entityManager->expects(self::never())->method('transactional');
        $this->entityManager->expects(self::never())->method('persist');

        $this->renderer->expects(self::once())->method('render')->with('account::register')->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::never())->method('setData');
        $this->form->expects(self::never())->method('isValid');
        $this->form->expects(self::never())->method('getData');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $this->entityManager->expects(self::never())->method('transactional');
        $this->entityManager->expects(self::never())->method('persist');

        $this->renderer->expects(self::once())->method('render')->with('account::register')->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::once())->method('setData')->with([
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
        ]);
        $this->form->expects(self::once())->method('isValid')->willReturn(false);
        $this->form->expects(self::never())->method('getData');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody([
                    'email' => '',
                    'password' => '',
                    'confirmPassword' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }


    public function testValidPostRequestCreatesUserAndRedirects()
    {
        $email = uniqid('email', true);
        $password = uniqid('password', true);
        $hash = uniqid('hash', true);
        $data = [
            'email' => $email,
            'password' => $password,
            'confirmPassword' => $password,
        ];

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $this->entityManager->expects(self::once())
            ->method('persist')
            ->with(self::callback(function (User $user) use ($email, $password) {
                self::assertSame($email, $user->getEmail());
                self::assertInstanceOf(AttendeeRole::class, $user->getRole());
                self::assertTrue($user->verifyPassword($this->hasher, $password));
                return true;
            }));

        $this->hasher->expects(self::once())->method('hash')->with($password)->willReturn($hash);
        $this->hasher->expects(self::once())->method('verify')->with($password, $hash)->willReturn(true);

        $this->renderer->expects(self::never())->method('render');

        $loginUrl = uniqid('/account/login', true);
        $this->urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-login')
            ->willReturn($loginUrl);

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
        self::assertSame($loginUrl, $response->getHeaderLine('Location'));
    }
}
