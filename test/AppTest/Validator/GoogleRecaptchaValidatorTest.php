<?php
declare(strict_types = 1);

namespace AppTest\Validator;

use App\Service\GoogleRecaptcha\VerifyGoogleRecaptchaInterface;
use App\Validator\GoogleRecaptchaValidator;

/**
 * @covers \App\Validator\GoogleRecaptchaValidator
 */
class GoogleRecaptchaValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValidReturnsTrueOnSuccess()
    {
        $verification = uniqid('verification', true);

        /** @var VerifyGoogleRecaptchaInterface|\PHPUnit_Framework_MockObject_MockObject $verifier */
        $verifier = $this->createMock(VerifyGoogleRecaptchaInterface::class);
        $verifier->expects(self::once())->method('__invoke')->with($verification)->willReturn([
            'success' => true,
        ]);

        self::assertTrue((new GoogleRecaptchaValidator($verifier))->isValid($verification));
    }

    public function testIsValidReturnsFalseAndSetsMessages()
    {
        $verification = uniqid('verification', true);

        /** @var VerifyGoogleRecaptchaInterface|\PHPUnit_Framework_MockObject_MockObject $verifier */
        $verifier = $this->createMock(VerifyGoogleRecaptchaInterface::class);
        $verifier->expects(self::once())->method('__invoke')->with($verification)->willReturn([
            'success' => false,
            'error-codes' => [
                'missing-input-response',
                'invalid-input-response',
                'missing-input-secret',
                'invalid-input-secret',
            ],
        ]);

        $validator = new GoogleRecaptchaValidator($verifier);
        self::assertFalse($validator->isValid($verification));

        self::assertSame(
            [
                'missing-input-response' => 'The response parameter is missing.',
                'invalid-input-response' => 'The response parameter is invalid or malformed.',
                'missing-input-secret' => 'The secret parameter is missing.',
                'invalid-input-secret' => 'The secret parameter is invalid or malformed.',
            ],
            $validator->getMessages()
        );
    }
}
