<?php
declare(strict_types = 1);

namespace App\Form\Account;

use App\Entity\Speaker;
use App\Service\Speaker\GetAllSpeakersInterface;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTimeSelect;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class TalkForm extends Form implements InputFilterProviderInterface
{
    public function __construct(GetAllSpeakersInterface $speakers)
    {
        parent::__construct('talkForm');

        $speakerList = $speakers();

        $this->add(
            (new DateTimeSelect('time'))
                ->setShouldShowSeconds(false)
                ->setLabel('Start Time')
        );

        $this->add(
            (new Select('speaker'))
                ->setEmptyOption('no speaker')
                ->setValueOptions(
                    array_combine(
                        array_map(function (Speaker $speaker) {
                            return $speaker->getId();
                        }, $speakerList),
                        array_map(function (Speaker $speaker) {
                            return $speaker->getFullName();
                        }, $speakerList)
                    )
                )
                ->setLabel('Speaker (optional)')
        );

        $this->add(
            (new Text('title'))
                ->setLabel('Talk title')
        );

        $this->add(
            (new Textarea('abstract'))
                ->setLabel('Abstract (optional)')
        );

        $this->add((new Submit('submit'))->setValue('Save'));
        $this->add(new Csrf('talkForm_csrf', [
            'csrf_options' => [
                'timeout' => 120,
            ],
        ]));
    }

    public function getInputFilterSpecification() : array
    {
        return [
            'time' => [
                'required' => true,
                'filters' => [
                    ['name' => \Zend\Filter\DateTimeSelect::class],
                ],
            ],
            'speaker' => [
                'required' => false,
            ],
            'title' => [
                'required' => true,
            ],
            'abstract' => [
                'required' => false,
            ],
        ];
    }
}
