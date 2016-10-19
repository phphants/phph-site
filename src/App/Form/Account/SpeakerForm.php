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

class SpeakerForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('speakerForm');

        $this->add((new Text('name'))->setLabel('Name'));
        $this->add((new Text('twitter'))->setLabel('Twitter Handle'));

        $this->add((new Submit('submit'))->setValue('Save'));
        $this->add(new Csrf('speakerForm_csrf', [
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
            'twitter' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}
