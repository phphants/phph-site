<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\LoginForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;

/**
 * @covers \App\Form\Account\LoginForm
 */
final class LoginFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $form = new LoginForm();

        self::assertInstanceOf(Text::class, $form->get('email'));
        self::assertInstanceOf(Password::class, $form->get('password'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('loginForm_csrf'));
    }
}
