<?php
declare(strict_types = 1);

namespace App\Form\Account;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class LocationForm extends Form
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
}
