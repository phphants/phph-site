<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineFindUserByEmail implements FindUserByEmailInterface
{
    /**
     * @var ObjectRepository
     */
    private $users;

    public function __construct(ObjectRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param string $email
     * @return User
     * @throws Exception\UserNotFound
     */
    public function __invoke(string $email) : User
    {
        /** @var User $user */
        $user = $this->users->findOneBy(['email' => $email]);

        if (null === $user) {
            throw Exception\UserNotFound::fromEmail($email);
        }

        return $user;
    }
}
