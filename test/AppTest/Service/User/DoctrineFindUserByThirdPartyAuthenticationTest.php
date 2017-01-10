<?php
declare(strict_types = 1);

namespace AppTest\Service\User;

use App\Entity\User;
use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\User\DoctrineFindUserByThirdPartyAuthentication;
use App\Service\User\Exception\UserNotFound;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;

/**
 * @covers \App\Service\User\DoctrineFindUserByThirdPartyAuthentication
 */
class DoctrineFindUserByThirdPartyAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeThrowsExceptionIfUserNotFound()
    {
        $id = uniqid('id', true);
        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            $id,
            uniqid('email', true),
            uniqid('displayName', true),
            []
        );

        /** @var AbstractQuery|\PHPUnit_Framework_MockObject_MockObject $query */
        $query = $this->createMock(AbstractQuery::class);
        $query->expects(self::once())
            ->method('execute')
            ->with([
                'tpType' => Twitter::class,
                'tpId' => $id,
            ]);
        $query->expects(self::once())->method('getSingleResult')->willThrowException(new NoResultException());

        /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('createQuery')
            ->willReturn($query);

        $this->expectException(UserNotFound::class);
        (new DoctrineFindUserByThirdPartyAuthentication($entityManager))->__invoke($authData);
    }

    public function testInvokeReturnsUserWhenFound()
    {
        $id = uniqid('id', true);
        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            $id,
            uniqid('email', true),
            uniqid('displayName', true),
            []
        );
        $user = User::fromThirdPartyAuthentication($authData);

        /** @var AbstractQuery|\PHPUnit_Framework_MockObject_MockObject $query */
        $query = $this->createMock(AbstractQuery::class);
        $query->expects(self::once())
            ->method('execute')
            ->with([
                'tpType' => Twitter::class,
                'tpId' => $id,
            ]);
        $query->expects(self::once())->method('getSingleResult')->willReturn($user);

        /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('createQuery')
            ->willReturn($query);

        self::assertSame($user, (new DoctrineFindUserByThirdPartyAuthentication($entityManager))->__invoke($authData));
    }
}
