<?php
declare(strict_types = 1);

namespace App\Validator;

use App\Service\GoogleRecaptcha\VerifyGoogleRecaptchaInterface;
use Zend\Validator\AbstractValidator;

final class GoogleRecaptchaValidator extends AbstractValidator
{
    const MISSING_INPUT_RESPONSE = 'missing-input-response';
    const INVALID_INPUT_RESPONSE = 'invalid-input-response';
    const MISSING_INPUT_SECRET = 'missing-input-secret';
    const INVALID_INPUT_SECRET = 'invalid-input-secret';

    protected $messageTemplates = [
        self::MISSING_INPUT_RESPONSE => 'The response parameter is missing.',
        self::MISSING_INPUT_SECRET => 'The secret parameter is missing.',
        self::INVALID_INPUT_RESPONSE => 'The response parameter is invalid or malformed.',
        self::INVALID_INPUT_SECRET => 'The secret parameter is invalid or malformed.',
    ];

    /**
     * @var VerifyGoogleRecaptchaInterface
     */
    private $verifyGoogleRecaptcha;

    public function __construct(VerifyGoogleRecaptchaInterface $verifyGoogleRecaptcha)
    {
        parent::__construct();

        $this->verifyGoogleRecaptcha = $verifyGoogleRecaptcha;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $response = $this->verifyGoogleRecaptcha->__invoke($value);

        if ($response['success']) {
            return true;
        }

        array_map(
            function (string $code) {
                $this->error($code);
            },
            $response['error-codes']
        );
        return false;
    }
}
