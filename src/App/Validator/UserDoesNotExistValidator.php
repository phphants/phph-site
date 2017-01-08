<?php
declare(strict_types = 1);

namespace App\Validator;

use App\Service\User\Exception\UserNotFound;
use App\Service\User\FindUserByEmailInterface;
use Zend\Validator\AbstractValidator;

final class UserDoesNotExistValidator extends AbstractValidator
{
    const USER_EXISTS = 'userExists';

    protected $messageTemplates = [
        self::USER_EXISTS => 'A user with this email already exists.',
    ];

    /**
     * @var FindUserByEmailInterface
     */
    private $findUserByEmail;

    public function __construct(FindUserByEmailInterface $findUserByEmail)
    {
        parent::__construct();

        $this->findUserByEmail = $findUserByEmail;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        try {
            $this->findUserByEmail->__invoke($value);
            $this->error(self::USER_EXISTS);
            return false;
        } catch (UserNotFound $userNotFound) {
            return true;
        }
    }
}
