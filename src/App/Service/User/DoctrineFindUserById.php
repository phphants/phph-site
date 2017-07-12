<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

class DoctrineFindUserById implements FindUserByIdInterface
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
