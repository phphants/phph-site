<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\RegisterForm;
use App\Validator\GoogleRecaptchaValidator;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Validator\ValidatorInterface;

/**
 * @covers \App\Form\Account\RegisterForm
 */
final class RegisterFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $recaptchaKey = uniqid('recaptchaKey', true);
        /** @var ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject $validator */
        $validator = $this->createMock(ValidatorInterface::class);
        $form = new RegisterForm($validator, $recaptchaKey);

        self::assertInstanceOf(Text::class, $form->get('email'));
        self::assertInstanceOf(Password::class, $form->get('password'));
        self::assertInstanceOf(Password::class, $form->get('confirmPassword'));
        self::assertInstanceOf(Hidden::class, $form->get('g-recaptcha-response'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('registerForm_csrf'));
    }

    public function testValidationForEmptySubmission()
    {
        $recaptchaKey = uniqid('recaptchaKey', true);
        /** @var ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject $validator */
        $validator = $this->createMock(ValidatorInterface::class);
        $form = new RegisterForm($validator, $recaptchaKey);

        $form->getInputFilter()->remove('registerForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
        ]);

        self::assertFalse($form->isValid());
        self::assertSame(
            [
                'email' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
                'password' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
                'confirmPassword' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
                'g-recaptcha-response' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
            ],
            $form->getMessages()
        );
    }

    public function testValidationForInvalidSubmission()
    {
        $recaptchaKey = uniqid('recaptchaKey', true);
        /** @var ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject $validator */
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects(self::once())->method('isValid')->willReturn(false);
        $validator->expects(self::once())->method('getMessages')->willReturn([
            GoogleRecaptchaValidator::INVALID_INPUT_RESPONSE => 'The response parameter is invalid or malformed.',
        ]);
        $form = new RegisterForm($validator, $recaptchaKey);
        $form->getInputFilter()->remove('registerForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'email' => uniqid('not a valid email', true),
            'password' => 'pwd',
            'confirmPassword' => uniqid('confirmPassword', true),
            'g-recaptcha-response' => uniqid('gRecaptchaResponse', true),
        ]);

        self::assertFalse($form->isValid());
        self::assertSame(
            [
                'email' => [
                    'emailAddressInvalidFormat'
                        => 'The input is not a valid email address. Use the basic format local-part@hostname',
                ],
                'password' => [
                    'stringLengthTooShort' => 'The input is less than 8 characters long',
                ],
                'confirmPassword' => [
                    'notSame' => 'The two given tokens do not match',
                ],
                'g-recaptcha-response' => [
                    'invalid-input-response' => 'The response parameter is invalid or malformed.',
                ],
            ],
            $form->getMessages()
        );
    }

    public function testValidationForValidSubmission()
    {
        $recaptchaKey = uniqid('recaptchaKey', true);
        /** @var ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject $validator */
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects(self::once())->method('isValid')->willReturn(true);
        $form = new RegisterForm($validator, $recaptchaKey);
        $form->getInputFilter()->remove('registerForm_csrf');
        $form->getInputFilter()->remove('submit');

        $password = uniqid('correct horse battery staple', true);
        $form->setData([
            'email' => 'valid@email.com',
            'password' => $password,
            'confirmPassword' => $password,
            'g-recaptcha-response' => uniqid('gRecaptchaResponse', true),
        ]);

        self::assertTrue($form->isValid());
        self::assertSame([], $form->getMessages());
    }
}
