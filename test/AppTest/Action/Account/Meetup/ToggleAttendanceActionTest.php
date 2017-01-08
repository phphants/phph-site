<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Meetup;

use App\Action\Account\Meetup\ToggleAttendanceAction;
use App\Entity\Location;
use App\Entity\Meetup;
use App\Entity\User;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\Location\FindLocationByUuidInterface;
use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Meetup\ToggleAttendanceAction
 */
final class ToggleAttendanceActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Meetup
     */
    private $meetup;

    /**
     * @var User
     */
    private $user;

    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var FindMeetupByUuidInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findMeetup;

    /**
     * @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $authenticationService;

    /**
     * @var ToggleAttendanceAction
     */
    private $action;

    public function setUp()
    {
        $this->meetup = Meetup::fromStandardMeetup(
            new \DateTimeImmutable('2016-06-01 19:00:00'),
            new \DateTimeImmutable('2016-06-01 23:00:00'),
            Location::fromNameAddressAndUrl('Location 1', 'Address 1', 'http://test-uri-1')
        );

        $this->user = User::new('foo@bar.com', new PhpPasswordHash(), 'correct horse battery staple');

        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $this->findMeetup->expects(self::once())
            ->method('__invoke')
            ->with($this->meetup->getId())
            ->willReturn($this->meetup);

        $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class);
        $this->authenticationService->expects(self::once())->method('getIdentity')->willReturn($this->user);

        $this->action = new ToggleAttendanceAction(
            $this->entityManager,
            $this->findMeetup,
            $this->authenticationService
        );
    }

    public function testAttendingUserCancelsAttendance()
    {
        $this->meetup->attend($this->user);

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $response = $this->action->__invoke(
            (new ServerRequest())
                ->withMethod('POST')
                ->withAttribute('uuid', $this->meetup->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\JsonResponse::class, $response);
        self::assertSame(
            [
                'attending' => false,
                'isPast' => true,
            ],
            json_decode($response->getBody()->getContents(), true)
        );
    }

    public function testUnattendingUserMarksAttendance()
    {
        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $response = $this->action->__invoke(
            (new ServerRequest())
                ->withMethod('POST')
                ->withAttribute('uuid', $this->meetup->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\JsonResponse::class, $response);
        self::assertSame(
            [
                'attending' => true,
                'isPast' => true,
            ],
            json_decode($response->getBody()->getContents(), true)
        );
    }
}
