<?php
declare(strict_types = 1);

namespace App\Form\Account;

use App\Entity\Location;
use App\Service\Location\GetAllLocationsInterface;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\DateTimeSelect;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class MeetupForm extends Form
{
    public function __construct(GetAllLocationsInterface $locations)
    {
        parent::__construct('meetupForm');

        $locationList = $locations();

        $this->add(
            (new DateTime('from'))
                ->setFormat('Y-m-d H:i')
                ->setLabel('From')
        );
        $this->add(
            (new DateTime('to'))
                ->setFormat('Y-m-d H:i')
                ->setLabel('To')
        );
        $this->add(
            (new Select('location'))
                ->setValueOptions(
                    array_combine(
                        array_map(function (Location $location) {
                            return $location->getId();
                        }, $locationList),
                        array_map(function (Location $location) {
                            return $location->getName();
                        }, $locationList)
                    )
                )
                ->setLabel('Location')
        );
        // @todo add talks
        $this->add((new Submit('submit'))->setValue('Save'));
        $this->add(new Csrf('meetupForm_csrf', [
            'csrf_options' => [
                'timeout' => 120,
            ],
        ]));
    }
}
