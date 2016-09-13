<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;

interface FindUserByEmailInterface
{
    /**
     * @param string $email
     * @return User
     * @throws Exception\UserNotFound
     */
    public function __invoke(string $email) : User;
}
