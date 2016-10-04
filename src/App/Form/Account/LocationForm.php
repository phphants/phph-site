<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Uri;

class LocationForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('locationForm');

        $this->add((new Text('name'))->setLabel('Name'));
        $this->add((new Text('address'))->setLabel('Address'));
        $this->add((new Text('url'))->setLabel('URL')->setAttribute('type', 'url'));

        $this->add((new Submit('submit'))->setValue('Save'));
        $this->add(new Csrf('locationForm_csrf', [
            'csrf_options' => [
                'timeout' => 120,
            ],
        ]));
    }

    public function getInputFilterSpecification() : array
    {
        return [
            'name' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'address' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'url' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => Uri::class,
                    ]
                ],
            ],
        ];
    }
}
