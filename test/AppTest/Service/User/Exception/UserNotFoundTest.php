<?php
declare(strict_types = 1);

namespace AppTest\Service\User\Exception;

use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\User\Exception\UserNotFound;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\User\Exception\UserNotFound
 */
class UserNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUsername()
    {
        $exception = UserNotFound::fromEmail('foo@bar.com');

        self::assertInstanceOf(UserNotFound::class, $exception);
        self::assertSame('User with email "foo@bar.com" was not found', $exception->getMessage());
    }

    public function testFromId()
    {
        $uuid = Uuid::uuid4();

        $exception = UserNotFound::fromId($uuid);

        self::assertInstanceOf(UserNotFound::class, $exception);
        self::assertSame('User with ID "' . (string)$uuid . '" was not found', $exception->getMessage());
    }

    public function testFromThirdPartyAuthentication()
    {
        $id = uniqid('id', true);
        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            $id,
            uniqid('email', true),
            uniqid('displayName', true),
            []
        );

        $exception = UserNotFound::fromThirdPartyAuthentication($authData);

        self::assertInstanceOf(UserNotFound::class, $exception);
        self::assertSame(
            sprintf('User for service "%s" with ID "%s" was not found', Twitter::class, $id),
            $exception->getMessage()
        );
    }
}
