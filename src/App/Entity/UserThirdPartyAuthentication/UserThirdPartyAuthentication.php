<?php
declare(strict_types=1);

namespace App\Entity\UserThirdPartyAuthentication;

use App\Entity\User;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user_third_party_authentication`")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="service", type="string", length=1024)
 * @ORM\DiscriminatorMap({
 *     GitHub::class = GitHub::class,
 *     Twitter::class = Twitter::class
 * })
 */
abstract class UserThirdPartyAuthentication
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="thirdPartyLogins")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="unique_id", type="string", length=1024, nullable=false)
     * @var string
     */
    private $uniqueId;

    /**
     * @ORM\Column(name="user_data", type="json_array", nullable=false)
     * @var string[]
     */
    protected $userData = [];

    /**
     * Should return a human-friendly name that represents the login, e.g. their username
     * @return string
     */
    abstract public function displayName() : string;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function new(User $user, ThirdPartyAuthenticationData $data) : self
    {
        $discriminator = $data->serviceClass();

        $instance = new $discriminator();
        Assertion::isInstanceOf($instance, self::class);

        $instance->user = $user;
        $instance->uniqueId = $data->uniqueId();
        $instance->userData = $data->userData();
        return $instance;
    }

    public function uniqueId() : string
    {
        return $this->uniqueId;
    }

    public function user() : User
    {
        return $this->user;
    }
}
