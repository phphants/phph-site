<?php
declare(strict_types = 1);

namespace AppTest\Service\User;

use App\Entity\User;
use App\Service\User\DoctrineFindUserById;
use App\Service\User\Exception\UserNotFound;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\User\DoctrineFindUserById
 */
class DoctrineFindUserByIdTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeThrowsExceptionIfUserNotFound()
    {
        $uuid = Uuid::uuid4();

        /** @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject $objectRepository */
        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('find')
            ->with((string)$uuid)
            ->willReturn(null);

        $this->expectException(UserNotFound::class);
        (new DoctrineFindUserById($objectRepository))->__invoke($uuid);
    }

    public function testInvokeReturnsUserWhenFound()
    {
        $uuid = Uuid::uuid4();

        /** @var User $user */
        $user = (new \ReflectionClass(User::class))->newInstanceWithoutConstructor();

        /** @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject $objectRepository */
        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('find')
            ->with((string)$uuid)
            ->willReturn($user);

        self::assertSame($user, (new DoctrineFindUserById($objectRepository))->__invoke($uuid));
    }
}
