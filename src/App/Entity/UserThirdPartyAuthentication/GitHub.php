<?php
declare(strict_types=1);

namespace App\Entity\UserThirdPartyAuthentication;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
/*final */class GitHub extends UserThirdPartyAuthentication
{
    public function displayName() : string
    {
        return $this->userData['username'] ?? $this->uniqueId();
    }
}
