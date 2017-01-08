<?php
declare(strict_types = 1);

namespace AppTest\Validator;

use App\Entity\User;
use App\Service\User\Exception\UserNotFound;
use App\Service\User\FindUserByEmailInterface;
use App\Service\User\PhpPasswordHash;
use App\Validator\UserDoesNotExistValidator;

/**
 * @covers \App\Validator\UserDoesNotExistValidator
 */
class UserDoesNotExistValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValidReturnsTrueOnSuccess()
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

    public function testIsValidReturnsFalseAndSetsMessages()
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
}
