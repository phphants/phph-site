<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;
use Ramsey\Uuid\UuidInterface;

interface FindUserByUuidInterface
{
    /**
     * @param UuidInterface $userId
     * @return User
     * @throws Exception\UserNotFound
     */
    public function __invoke(UuidInterface $userId) : User;
}
