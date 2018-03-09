<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\Location;
use App\Entity\Meetup;
use App\Entity\User;
use App\Entity\UserThirdPartyAuthentication\GitHub;
use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;
use App\Service\User\PasswordHashInterface;
use App\Service\User\PhpPasswordHash;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Entity\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testFromThirdPartyAuthentication()
    {
        $email = uniqid('email', true);
        $displayName = uniqid('displayName', true);

        $user = User::fromThirdPartyAuthentication(ThirdPartyAuthenticationData::new(
            Twitter::class,
            uniqid('id', true),
            $email,
            $displayName,
            []
        ));

        self::assertInstanceOf(User::class, $user);
        self::assertSame($email, $user->getEmail());
        self::assertSame($displayName, $user->displayName());
        self::assertCount(1, $user->thirdPartyLogins());
    }

    public function testGetEmail()
    {
        $email = uniqid('email', true);
        $user = User::new($email, 'My Name', new PhpPasswordHash(), '');

        self::assertSame($email, $user->getEmail());
    }

    public function testGetDisplayName()
    {
        $displayName = uniqid('displayName', true);
        $user = User::new('foo@bar.com', $displayName, new PhpPasswordHash(), '');

        self::assertSame($displayName, $user->displayName());
    }

    public function testPasswordVerification()
    {
        $plaintext = uniqid('plaintext', true);

        $hasher = new PhpPasswordHash();

        $user = User::new('foo@bar.com', 'My Name', $hasher, $plaintext);

        self::assertFalse($user->verifyPassword($hasher, uniqid('incorrect password', true)));
        self::assertTrue($user->verifyPassword($hasher, $plaintext));
    }

    public function testVerifyPasswordReturnsFalseEarlyWhenPasswordIsBlank()
    {
        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);
        $hasher->expects(self::never())->method('verify');

        $originalPassword = uniqid('plaintext', true);
        $user = User::new('foo@bar.com', 'My Name', $hasher, $originalPassword);

        $passwordProperty = new \ReflectionProperty($user, 'password');
        $passwordProperty->setAccessible(true);
        $passwordProperty->setValue($user, '');

        self::assertFalse($user->verifyPassword($hasher, $originalPassword));
        self::assertFalse($user->verifyPassword($hasher, ''));
    }

    public function roleProvider()
    {
        return [
            'administrator' => [AdministratorRole::NAME, AdministratorRole::class],
            'attendee' => [AttendeeRole::NAME, AttendeeRole::class],
        ];
    }

    /**
     * @param string $roleName
     * @param string $expectedClass
     * @dataProvider roleProvider
     */
    public function testGetRole(string $roleName, string $expectedClass)
    {
        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), 'password');

        $roleProperty = new \ReflectionProperty($user, 'role');
        $roleProperty->setAccessible(true);
        $roleProperty->setValue($user, $roleName);

        self::assertInstanceOf($expectedClass, $user->getRole());
    }

    public function testDefaultRoleIsAttendee()
    {
        self::assertInstanceOf(
            AttendeeRole::class,
            User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), 'password')
                ->getRole()
        );
    }

    public function testMeetupAttendance()
    {
        $from = new \DateTimeImmutable('2016-06-01 19:00:00');
        $to = new \DateTimeImmutable('2016-06-01 23:00:00');
        $location = Location::fromNameAddressAndUrl('Location 1', 'Address 1', 'http://test-uri-1');

        $meetup = Meetup::fromStandardMeetup($from, $to, $location);

        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), 'password');
        self::assertFalse($user->isAttending($meetup));

        $meetup->attend($user);
        self::assertTrue($user->isAttending($meetup));

        $meetup->cancelAttendance($user);
        self::assertFalse($user->isAttending($meetup));
    }

    public function testTwitterHandleReturnsNullWhenNoTwitterLoginExists()
    {
        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), 'password');
        self::assertNull($user->twitterHandle());
    }

    public function testTwitterHandleReturnsString()
    {
        $twitterHandle = uniqid('twitterHandle', true);

        $user = User::fromThirdPartyAuthentication(ThirdPartyAuthenticationData::new(
            Twitter::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            [
                'twitter' => $twitterHandle,
            ]
        ));

        self::assertSame($twitterHandle, $user->twitterHandle());
    }

    public function testGitHubUsernameReturnsNullWhenNoGitHubLoginExists()
    {
        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), 'password');
        self::assertNull($user->githubUsername());
    }

    public function testGitHubUsernameReturnsString()
    {
        $gitHubUsername = uniqid('gitHubUsername', true);

        $user = User::fromThirdPartyAuthentication(ThirdPartyAuthenticationData::new(
            GitHub::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            [
                'username' => $gitHubUsername,
            ]
        ));

        self::assertSame($gitHubUsername, $user->githubUsername());
    }

    public function testAssociatingNewThirdPartyLoginToExistingUser(): void
    {
        $user = User::new(uniqid('email', true), uniqid('name', true), new PhpPasswordHash(), uniqid('password', true));

        self::assertCount(0, $user->thirdPartyLogins());

        $user->associateThirdPartyLogin(ThirdPartyAuthenticationData::new(
            GitHub::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            [
                'username' => uniqid('githubUsername', true),
            ]
        ));

        self::assertCount(1, $user->thirdPartyLogins());
    }

    public function testThirdPartyLoginCanBeDisassociatedFromUser(): void
    {
        $user = User::fromThirdPartyAuthentication(ThirdPartyAuthenticationData::new(
            GitHub::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            [
                'username' => uniqid('githubUsername', true),
            ]
        ));

        self::assertCount(1, $user->thirdPartyLogins());

        /** @var GitHub $thirdPartyLogin */
        $thirdPartyLogin = array_values($user->thirdPartyLogins())[0];

        $user->disassociateThirdPartyLoginByUuid(Uuid::fromString($thirdPartyLogin->id()));

        self::assertCount(0, $user->thirdPartyLogins());
    }

    public function testDomainExceptionIsThrownWhenUserDoesNotHaveMatchingThirdPartyLoginToDisassociate(): void
    {
        $email = uniqid('email', true);
        $user = User::new($email, uniqid('name', true), new PhpPasswordHash(), uniqid('password', true));
        $idToRemove = Uuid::uuid4();
        self::assertCount(0, $user->thirdPartyLogins());

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage(sprintf('User %s does not have a login for %s', $email, (string)$idToRemove));
        $user->disassociateThirdPartyLoginByUuid($idToRemove);
    }

    public function testAssociatingExactlyTheSameThirdPartyLoginTwiceDoesNotAddItAgain()
    {
        $authData = ThirdPartyAuthenticationData::new(
            GitHub::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            [
                'username' => uniqid('githubUsername', true),
            ]
        );
        $user = User::fromThirdPartyAuthentication($authData);

        self::assertCount(1, $user->thirdPartyLogins());

        $user->associateThirdPartyLogin($authData);

        self::assertCount(1, $user->thirdPartyLogins());
    }

    public function testUserPasswordCanBeChanged()
    {
        $algo = new PhpPasswordHash();

        $firstPassword = uniqid('firstPassword', true);
        $secondPassword = uniqid('secondPassword', true);
        $user = User::new(uniqid('email', true), uniqid('name', true), $algo, $firstPassword);
        self::assertTrue($user->verifyPassword($algo, $firstPassword));
        self::assertFalse($user->verifyPassword($algo, $secondPassword));

        $user->changePassword($algo, $secondPassword);
        self::assertFalse($user->verifyPassword($algo, $firstPassword));
        self::assertTrue($user->verifyPassword($algo, $secondPassword));
    }
}
