<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;

final class ChangePasswordForm extends Form implements InputFilterProviderInterface
{
    /**
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('changePasswordForm_csrf');

        $this->add((new Password('password'))->setLabel('Password'));
        $this->add((new Password('confirmPassword'))->setLabel('Confirm Password'));
        $this->add((new Submit('submit'))->setValue('Change'));
        $this->add(new Csrf('changePasswordForm_csrf', [
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
