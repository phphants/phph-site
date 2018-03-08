<?php
declare(strict_types=1);

namespace AppTest\Action\Account;

use App\Action\Account\UnlinkThirdPartyAuthenticationAction;
use App\Entity\User;
use App\Service\Authentication\AuthenticationServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @covers \App\Action\Account\UnlinkThirdPartyAuthenticationAction
 */
final class UnlinkThirdPartyAuthenticationActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $authenticationService;

    /**
     * @var UrlHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $urlHelper;

    /**
     * @var UnlinkThirdPartyAuthenticationAction
     */
    private $action;

    public function setUp()
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);

        $this->action = new UnlinkThirdPartyAuthenticationAction(
            $this->entityManager,
            $this->authenticationService,
            $this->urlHelper
        );
    }

    public function testIdentityIsDisassociatedAndRedirectsToSettings() : void
    {
        $idToRemove = Uuid::uuid4();

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $user = $this->createMock(User::class);
        $user->expects(self::once())->method('disassociateThirdPartyLoginByUuid')->with($idToRemove);

        $expectedUrl = uniqid('expectedUrl', true);
        $this->urlHelper->expects(self::once())->method('generate')->with('account-settings')->willReturn($expectedUrl);

        $this->authenticationService->expects(self::once())->method('getIdentity')->willReturn($user);

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withAttribute('loginId', (string)$idToRemove),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($expectedUrl, $response->getHeaderLine('Location'));
    }
}
