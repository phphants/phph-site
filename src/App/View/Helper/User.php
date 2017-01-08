<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\Authorization\AuthorizationServiceInterface;
use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;
use Zend\View\Helper\AbstractHelper;

final class User extends AbstractHelper
{
    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        AuthorizationServiceInterface $authorizationService
    ) {
        $this->authenticationService = $authenticationService;
        $this->authorizationService = $authorizationService;
    }

    public function isLoggedIn() : bool
    {
        return $this->authenticationService->hasIdentity();
    }

    public function isAdministrator() : bool
    {
        return $this->authorizationService->hasRole(new AdministratorRole());
    }
}
