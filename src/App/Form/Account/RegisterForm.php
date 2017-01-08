<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorInterface;

class RegisterForm extends Form implements InputFilterProviderInterface
{
    /**
     * @var ValidatorInterface
     */
    private $recaptchaValidator;

    /**
     * @var ValidatorInterface
     */
    private $userDoesNotExistValidator;

    public function __construct(
        ValidatorInterface $recaptchaValidator,
        string $recaptchaPublicKey,
        ValidatorInterface $userDoesNotExistValidator
    ) {
        parent::__construct('registerForm');

        $this->recaptchaValidator = $recaptchaValidator;
        $this->userDoesNotExistValidator = $userDoesNotExistValidator;

        $this->add((new Text('email'))->setLabel('Email Address'));
        $this->add((new Password('password'))->setLabel('Password'));
        $this->add((new Password('confirmPassword'))->setLabel('Confirm Password'));
        $this->add((new Submit('submit'))->setValue('Register'));
        $this->add((new Hidden('g-recaptcha-response'))->setAttribute('recaptchaPublicKey', $recaptchaPublicKey));
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
                    $this->userDoesNotExistValidator,
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
            'g-recaptcha-response' => [
                'validators' => [
                    $this->recaptchaValidator,
                ],
            ],
        ];
    }
}
