<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\MeetupForm;
use App\Service\Location\GetAllLocationsInterface;
use App\Service\Speaker\GetAllSpeakersInterface;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTimeSelect;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputInterface;


/**
 * @covers \App\Form\Account\MeetupForm
 */
final class MeetupFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $locations = $this->createMock(GetAllLocationsInterface::class);
        $speakers = $this->createMock(GetAllSpeakersInterface::class);

        $form = new MeetupForm($locations, $speakers);

        self::assertInstanceOf(DateTimeSelect::class, $form->get('from'));
        self::assertInstanceOf(DateTimeSelect::class, $form->get('to'));
        self::assertInstanceOf(Select::class, $form->get('location'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('meetupForm_csrf'));
    }

    public function testInputFilterSpecificationIsValid()
    {
        $locations = $this->createMock(GetAllLocationsInterface::class);
        $speakers = $this->createMock(GetAllSpeakersInterface::class);

        $inputFilter = (new InputFilterFactory())->createInputFilter(new MeetupForm($locations, $speakers));
        self::assertInstanceOf(InputFilterInterface::class, $inputFilter);
        self::assertInstanceOf(InputInterface::class, $inputFilter->get('from'));
        self::assertInstanceOf(InputInterface::class, $inputFilter->get('to'));
    }
}
