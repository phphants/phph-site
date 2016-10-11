<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\TalkForm;
use App\Service\Speaker\GetAllSpeakersInterface;
use Zend\Form\Element\DateTimeSelect;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputInterface;

/**
 * @covers \App\Form\Account\TalkForm
 */
final class TalkFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $speakers = $this->createMock(GetAllSpeakersInterface::class);

        $form = new TalkForm($speakers);

        self::assertInstanceOf(DateTimeSelect::class, $form->get('time'));
        self::assertInstanceOf(Select::class, $form->get('speaker'));
        self::assertInstanceOf(Text::class, $form->get('title'));
        self::assertInstanceOf(Textarea::class, $form->get('abstract'));
    }

    public function testInputFilterSpecificationIsValid()
    {
        $speakers = $this->createMock(GetAllSpeakersInterface::class);

        $inputFilter = (new InputFilterFactory())->createInputFilter(new TalkForm($speakers));
        self::assertInstanceOf(InputFilterInterface::class, $inputFilter);
        self::assertInstanceOf(InputInterface::class, $inputFilter->get('time'));
        self::assertInstanceOf(InputInterface::class, $inputFilter->get('speaker'));
        self::assertInstanceOf(InputInterface::class, $inputFilter->get('title'));
        self::assertInstanceOf(InputInterface::class, $inputFilter->get('abstract'));
    }
}
