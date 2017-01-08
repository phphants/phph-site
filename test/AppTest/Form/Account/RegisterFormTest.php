<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\RegisterForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;

/**
 * @covers \App\Form\Account\RegisterForm
 */
final class RegisterFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $form = new RegisterForm();

        self::assertInstanceOf(Text::class, $form->get('email'));
        self::assertInstanceOf(Password::class, $form->get('password'));
        self::assertInstanceOf(Password::class, $form->get('confirmPassword'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('registerForm_csrf'));
    }

    public function testValidationForEmptySubmission()
    {
        $form = new RegisterForm();
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
            ],
            $form->getMessages()
        );
    }

    public function testValidationForInvalidSubmission()
    {
        $form = new RegisterForm();
        $form->getInputFilter()->remove('registerForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'email' => uniqid('not a valid email', true),
            'password' => 'pwd',
            'confirmPassword' => uniqid('confirmPassword', true),
        ]);

        self::assertFalse($form->isValid());
        self::assertSame(
            [
                'email' => [
                    'emailAddressInvalidFormat' => 'The input is not a valid email address. Use the basic format local-part@hostname',
                ],
                'password' => [
                    'stringLengthTooShort' => 'The input is less than 8 characters long',
                ],
                'confirmPassword' => [
                    'notSame' => 'The two given tokens do not match',
                ],
            ],
            $form->getMessages()
        );
    }

    public function testValidationForValidSubmission()
    {
        $form = new RegisterForm();
        $form->getInputFilter()->remove('registerForm_csrf');
        $form->getInputFilter()->remove('submit');

        $password = uniqid('correct horse battery staple', true);
        $form->setData([
            'email' => 'valid@email.com',
            'password' => $password,
            'confirmPassword' => $password,
        ]);

        self::assertTrue($form->isValid());
        self::assertSame([], $form->getMessages());
    }
}
