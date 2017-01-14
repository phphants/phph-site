<?php
declare(strict_types = 1);

namespace App\Service\Authentication;

final class ThirdPartyAuthenticationData
{
    /**
     * @var string
     */
    private $serviceClass;

    /**
     * @var string
     */
    private $uniqueId;

    /**
     * @var string[]
     */
    private $userData;

    private function __construct()
    {
    }

    public static function new(
        string $serviceClass,
        string $uniqueId,
        string $email,
        string $displayName,
        array $userData
    ) : self {
        $instance = new self();
        $instance->serviceClass = $serviceClass;
        $instance->uniqueId = $uniqueId;
        $instance->userData = $userData;
        $instance->userData['email'] = $email;
        $instance->userData['displayName'] = $displayName;
        return $instance;
    }

    public function serviceClass() : string
    {
        return $this->serviceClass;
    }

    public function uniqueId() : string
    {
        return $this->uniqueId;
    }

    public function email() : string
    {
        return $this->userData['email'];
    }

    public function displayName() : string
    {
        return $this->userData['displayName'];
    }

    public function userData() : array
    {
        return $this->userData;
    }
}
