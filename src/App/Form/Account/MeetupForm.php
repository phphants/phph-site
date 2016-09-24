<?php
declare(strict_types = 1);

namespace App\Form\Account;

use App\Entity\Location;
use App\Service\Location\GetAllLocationsInterface;
use App\Service\Speaker\GetAllSpeakersInterface;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTimeSelect;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class MeetupForm extends Form implements InputFilterProviderInterface
{
    public function __construct(GetAllLocationsInterface $locations, GetAllSpeakersInterface $speakers)
    {
        parent::__construct('meetupForm');

        $locationList = $locations();

        $this->add(
            (new DateTimeSelect('from'))
                ->setOptions([
                    'should_show_seconds' => false,
                    'min_year' => 2010,
                    'max_year' => date('Y') + 2,
                ])
                ->setLabel('From')
                ->setValue((new \DateTimeImmutable('now 19:00:00'))->format('Y-m-d H:i:s'))
        );
        $this->add(
            (new DateTimeSelect('to'))
                ->setOptions([
                    'should_show_seconds' => false,
                    'min_year' => 2010,
                    'max_year' => date('Y') + 2,
                ])
                ->setLabel('To')
                ->setValue((new \DateTimeImmutable('now 23:00:00'))->format('Y-m-d H:i:s'))
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

        $this->add((new Submit('submit'))->setValue('Save'));
        $this->add(new Csrf('meetupForm_csrf', [
            'csrf_options' => [
                'timeout' => 120,
            ],
        ]));
    }

    public function getInputFilterSpecification()
    {
        return [
            'from' => [
                'filters' => [
                    ['name' => \Zend\Filter\DateTimeSelect::class],
                ],
            ],
            'to' => [
                'filters' => [
                    ['name' => \Zend\Filter\DateTimeSelect::class],
                ],
            ],
        ];
    }
}
