<?php
declare(strict_types=1);

namespace AppTest\Form\Account;

use App\Form\Account\ChangePasswordForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;

/**
 * @covers \App\Form\Account\ChangePasswordForm
 */
final class ChangePasswordFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields(): void
    {
        $form = new ChangePasswordForm();

        self::assertInstanceOf(Password::class, $form->get('password'));
        self::assertInstanceOf(Password::class, $form->get('confirmPassword'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('changePasswordForm_csrf'));
    }

    public function testValidationForEmptySubmission(): void
    {
        $form = new ChangePasswordForm();

        $form->getInputFilter()->remove('changePasswordForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'password' => '',
            'confirmPassword' => '',
        ]);

        self::assertFalse($form->isValid());
        self::assertSame(
            [
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

    public function testValidationForInvalidSubmission(): void
    {
        $form = new ChangePasswordForm();

        $form->getInputFilter()->remove('changePasswordForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'password' => 'pwd',
            'confirmPassword' => uniqid('confirmPassword', true),
        ]);

        self::assertFalse($form->isValid());
        self::assertSame(
            [
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

    public function testValidationForValidSubmission(): void
    {
        $form = new ChangePasswordForm();

        $form->getInputFilter()->remove('changePasswordForm_csrf');
        $form->getInputFilter()->remove('submit');

        $password = uniqid('correct horse battery staple', true);
        $form->setData([
            'password' => $password,
            'confirmPassword' => $password,
        ]);

        self::assertTrue($form->isValid());
        self::assertSame([], $form->getMessages());
    }
}
