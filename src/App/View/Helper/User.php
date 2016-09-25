<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Service\Authentication\AuthenticationServiceInterface;
use Zend\View\Helper\AbstractHelper;

final class User extends AbstractHelper
{
    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function isLoggedIn() : bool
    {
        return $this->authenticationService->hasIdentity();
    }
}
