<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;

class RegisterForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('registerForm');

        $this->add((new Text('email'))->setLabel('Email Address'));
        $this->add((new Password('password'))->setLabel('Password'));
        $this->add((new Password('confirmPassword'))->setLabel('Confirm Password'));
        $this->add((new Submit('submit'))->setValue('Register'));
        $this->add(new Csrf('registerForm_csrf', [
            'csrf_options' => [
                'timeout' => 120,
            ],
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function getInputFilterSpecification() : array
    {
        return [
            'email' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => EmailAddress::class,
                    ],
                    // @todo verify user does not already exist
                ],
            ],
            'password' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 8,
                        ],
                    ],
                ],
            ],
            'confirmPassword' => [
                'validators' => [
                    [
                        'name' => Identical::class,
                        'options' => [
                            'token' => 'password',
                            'strict' => true,
                            'literal' => false,
                        ],
                    ],
                ],
            ],
        ];
    }
}
