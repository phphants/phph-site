<?php
declare(strict_types = 1);

namespace App\Form\Account;

use App\Entity\Speaker;
use App\Service\Speaker\GetAllSpeakersInterface;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTimeSelect;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Regex;

class TalkForm extends Form implements InputFilterProviderInterface
{
    const YOUTUBE_VALIDATION_MESSAGE = 'YouTube video IDs must consist of 11 alphanumeric characters with - or _';

    public function __construct(GetAllSpeakersInterface $speakers)
    {
        parent::__construct('talkForm');

        $speakerList = $speakers();

        $this->add(
            (new DateTimeSelect('time'))
                ->setShouldShowSeconds(false)
                ->setMaxYear(date('Y') + 1)
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

        $this->add(
            (new Text('youtubeId'))
                ->setLabel('YouTube Id (leave blank for none)')
                ->setAttributes([
                    'placeholder' => 'stVnFCyDyeY',
                ])
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
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'abstract' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'youtubeId' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => Regex::class,
                        'options' => [
                            'pattern' => '/^[a-zA-Z0-9_-]{11}$/',
                            'messages' => [
                                Regex::NOT_MATCH => self::YOUTUBE_VALIDATION_MESSAGE,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
