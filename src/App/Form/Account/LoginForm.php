<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('loginForm');

        $this->add((new Text('email'))->setLabel('Email Address'));
        $this->add((new Password('password'))->setLabel('Password'));
        $this->add((new Submit('submit'))->setValue('Login'));
        $this->add(new Csrf('loginForm_csrf', [
            'csrf_options' => [
                'timeout' => 120,
            ],
        ]));
    }
}
