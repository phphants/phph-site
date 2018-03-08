<?php
declare(strict_types=1);

namespace App\Entity\UserThirdPartyAuthentication;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
/*final */class Twitter extends UserThirdPartyAuthentication
{
    public function twitter() : ?string
    {
        return $this->userData['twitter'] ?? null;
    }

    public function displayName() : string
    {
        return $this->twitter();
    }

    public static function routeNameForAuthentication() : string
    {
        return 'account-twitter-authenticate';
    }
}
