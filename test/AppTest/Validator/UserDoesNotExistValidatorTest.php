<?php
declare(strict_types = 1);

namespace AppTest\Validator;

use App\Entity\User;
use App\Service\User\Exception\UserNotFound;
use App\Service\User\FindUserByEmailInterface;
use App\Service\User\PhpPasswordHash;
use App\Validator\UserDoesNotExistValidator;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Validator\UserDoesNotExistValidator
 */
class UserDoesNotExistValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValidReturnsTrueOnSuccess(): void
    {
        $email = uniqid('email@email.com', true);

        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $findUserByEmail */
        $findUserByEmail = $this->createMock(FindUserByEmailInterface::class);
        $findUserByEmail->expects(self::once())
            ->method('__invoke')
            ->with($email)
            ->willThrowException(new UserNotFound());

        self::assertTrue((new UserDoesNotExistValidator($findUserByEmail))->isValid($email));
    }

    public function testIsValidReturnsFalseAndSetsMessages(): void
    {
        $email = uniqid('email@email.com', true);

        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $findUserByEmail */
        $findUserByEmail = $this->createMock(FindUserByEmailInterface::class);
        $findUserByEmail->expects(self::once())
            ->method('__invoke')
            ->with($email)
            ->willReturn(User::new($email, 'My Name', new PhpPasswordHash(), 'correct horse battery staple'));

        $validator = new UserDoesNotExistValidator($findUserByEmail);
        self::assertFalse($validator->isValid($email));

        self::assertSame(
            [
                'userExists' => 'A user with this email already exists.',
            ],
            $validator->getMessages()
        );
    }

    public function testIsValidReturnsTrueWhenUserIsUpdatingTheirOwnEmail(): void
    {
        $email = uniqid('email@email.com', true);
        $user = User::new($email, uniqid('name', true), new PhpPasswordHash(), uniqid('password', true));

        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $findUserByEmail */
        $findUserByEmail = $this->createMock(FindUserByEmailInterface::class);
        $findUserByEmail->expects(self::once())
            ->method('__invoke')
            ->with($email)
            ->willReturn($user);

        self::assertTrue((new UserDoesNotExistValidator($findUserByEmail))->isValid($email, ['userId' => $user->id()]));
    }

    public function testIsValidReturnsFalseWhenUserIsUpdatingTheirEmailToOneBelongingToSomeoneElse(): void
    {
        $email = uniqid('email@email.com', true);

        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $findUserByEmail */
        $findUserByEmail = $this->createMock(FindUserByEmailInterface::class);
        $findUserByEmail->expects(self::once())
            ->method('__invoke')
            ->with($email)
            ->willReturn(User::new($email, uniqid('name', true), new PhpPasswordHash(), uniqid('password', true)));

        $validator = new UserDoesNotExistValidator($findUserByEmail);
        self::assertFalse($validator->isValid($email, ['userId' => (string)Uuid::uuid4()]));
        self::assertEquals(
            [
                'userExists' => 'A user with this email already exists.',
            ],
            $validator->getMessages()
        );
    }
}
