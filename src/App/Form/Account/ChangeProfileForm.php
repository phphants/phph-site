<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\ValidatorInterface;

class ChangeProfileForm extends Form implements InputFilterProviderInterface
{
    /**
     * @var ValidatorInterface
     */
    private $userDoesNotExistValidator;

    /**
     * {@inheritDoc}
     * @param ValidatorInterface $userDoesNotExistValidator
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct(ValidatorInterface $userDoesNotExistValidator)
    {
        parent::__construct('changeProfileForm');

        $this->userDoesNotExistValidator = $userDoesNotExistValidator;

        $this->add(new Hidden('userId'));
        $this->add((new Text('name'))->setLabel('Your Name'));
        $this->add((new Text('email'))->setLabel('Email Address'));
        $this->add((new Submit('submit'))->setValue('Register'));
        $this->add(new Csrf('changeProfileForm_csrf', [
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
            'name' => [
                'required' => true,
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class],
                ],
            ],
            'email' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => EmailAddress::class,
                    ],
                    $this->userDoesNotExistValidator,
                ],
            ],
        ];
    }
}
