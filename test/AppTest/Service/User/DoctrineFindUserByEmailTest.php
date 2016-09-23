<?php
declare(strict_types = 1);

namespace AppTest\Service\User;

use App\Entity\User;
use App\Service\User\DoctrineFindUserByEmail;
use App\Service\User\Exception\UserNotFound;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @covers \App\Service\User\DoctrineFindUserByEmail
 */
class DoctrineFindUserByEmailTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeThrowsExceptionIfUserNotFound()
    {
        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['email' => 'foo@bar.com'])
            ->willReturn(null);

        $this->expectException(UserNotFound::class);
        (new DoctrineFindUserByEmail($objectRepository))->__invoke('foo@bar.com');
    }

    public function testInvokeReturnsUserWhenFound()
    {
        /** @var User $user */
        $user = (new \ReflectionClass(User::class))->newInstanceWithoutConstructor();

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['email' => 'foo@bar.com'])
            ->willReturn($user);

        self::assertSame($user, (new DoctrineFindUserByEmail($objectRepository))->__invoke('foo@bar.com'));
    }
}
