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
    public function isValid($value, array $context = null)
    {
        try {
            $user = $this->findUserByEmail->__invoke($value);

            if (null !== $context && array_key_exists('userId', $context) && $user->id() === $context['userId']) {
                return true;
            }

            $this->error(self::USER_EXISTS);
            return false;
        } catch (UserNotFound $userNotFound) {
            return true;
        }
    }
}
