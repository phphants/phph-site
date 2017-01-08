<?php
declare(strict_types=1);

namespace App\Entity;

use App\Service\Authorization\Role\RoleFactory;
use App\Service\Authorization\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
/*final */class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(name="email", type="string", length=1024, nullable=false, unique=true)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=1024, nullable=false)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(name="role", type="string", length=1024, nullable=false)
     * @var string
     */
    private $role;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function verifyPassword(string $password) : bool
    {
        return password_verify($password, $this->password);
    }

    public function getRole() : RoleInterface
    {
        return RoleFactory::getRole($this->role);
    }
}
