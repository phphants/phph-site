<?php
declare(strict_types = 1);

namespace App\Service\Authentication;

use App\Entity\User;
use App\Service\User\Exception\UserNotFound;
use App\Service\User\FindUserByEmailInterface;
use App\Service\User\FindUserByThirdPartyAuthenticationInterface;
use App\Service\User\PasswordHashInterface;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Authentication\Storage\StorageInterface;

class ZendAuthenticationService implements AuthenticationServiceInterface
{
    /**
     * @var FindUserByEmailInterface
     */
    private $findUserByEmail;

    /**
     * @var FindUserByThirdPartyAuthenticationInterface
     */
    private $findUserByThirdPartyAuthentication;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var PasswordHashInterface
     */
    private $passwordAlgorithm;

    public function __construct(
        FindUserByEmailInterface $findUserByEmail,
        FindUserByThirdPartyAuthenticationInterface $findUserByThirdPartyAuthentication,
        EntityManagerInterface $entityManager,
        StorageInterface $storage,
        PasswordHashInterface $passwordAlgorithm
    ) {
        $this->findUserByEmail = $findUserByEmail;
        $this->findUserByThirdPartyAuthentication = $findUserByThirdPartyAuthentication;
        $this->entityManager = $entityManager;
        $this->storage = $storage;
        $this->passwordAlgorithm = $passwordAlgorithm;
    }

    public function authenticate(string $login, string $password) : bool
    {
        try {
            $user = $this->findUserByEmail->__invoke($login);
        } catch (UserNotFound $userNotFound) {
            return false;
        }

        if (!$user->verifyPassword($this->passwordAlgorithm, $password)) {
            return false;
        }

        $this->storage->write($user->getEmail());
        return true;
    }

    public function thirdPartyAuthenticate(ThirdPartyAuthenticationData $thirdPartyAuthentication) : bool
    {
        try {
            $user = $this->findUserByThirdPartyAuthentication->__invoke($thirdPartyAuthentication);
        } catch (UserNotFound $userNotFound) {
            $user = $this->entityManager->transactional(function () use ($thirdPartyAuthentication) {
                $user = User::fromThirdPartyAuthentication($thirdPartyAuthentication);
                $this->entityManager->persist($user);
                return $user;
            });
        }

        $this->storage->write($user->getEmail());
        return true;
    }

    public function hasIdentity() : bool
    {
        return !$this->storage->isEmpty();
    }

    public function getIdentity() : User
    {
        if (!$email = $this->storage->read()) {
            throw Exception\NotAuthenticated::fromNothing();
        }

        return $this->findUserByEmail->__invoke($email);
    }

    public function clearIdentity() : bool
    {
        $this->storage->clear();
        return true;
    }
}
