<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

class DoctrineFindUserByUuid implements FindUserByUuidInterface
{
    /**
     * @var ObjectRepository
     */
    private $users;

    public function __construct(ObjectRepository $users)
    {
        $this->users = $users;
    }

    public function __invoke(UuidInterface $userId) : User
    {
        /** @var User $user */
        $user = $this->users->find((string)$userId);

        if (null === $user) {
            throw Exception\UserNotFound::fromId($userId);
        }

        return $user;
    }
}
