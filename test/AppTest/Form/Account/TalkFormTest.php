<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Entity\Speaker;
use App\Form\Account\TalkForm;
use App\Service\Speaker\GetAllSpeakersInterface;
use Zend\Form\Element\DateTimeSelect;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputInterface;
use Zend\Validator\Date;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

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
        self::assertInstanceOf(Text::class, $form->get('youtubeId'));
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
        self::assertInstanceOf(InputInterface::class, $inputFilter->get('youtubeId'));
    }

    public function testFilteringOnFields()
    {
        $speakers = $this->createMock(GetAllSpeakersInterface::class);

        $form = new TalkForm($speakers);
        $form->getInputFilter()->remove('talkForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'time' => [
                'year' => '2016',
                'month' => '12',
                'day' => '31',
                'hour' => '23',
                'minute' => '59',
            ],
            'title' => ' foo<bar>baz ',
            'abstract' => ' foo<bar>baz ',
            'youtubeId' => '',
        ]);

        $form->isValid();

        self::assertSame([
            'time' => '2016-12-31 23:59:00',
            'speaker' => null,
            'title' => 'foobaz',
            'abstract' => 'foobaz',
            'youtubeId' => '',
        ], $form->getData());
    }

    public function testValidationFailureWithMessages()
    {
        $speakers = $this->createMock(GetAllSpeakersInterface::class);

        $form = new TalkForm($speakers);
        $form->getInputFilter()->remove('talkForm_csrf');

        $form->setData([
            'time' => [
                'year' => '5001',
                'month' => '22',
                'day' => '65',
                'hour' => '24',
                'minute' => '62',
            ],
            'speaker' => 'foo',
            'title' => '',
            'abstract' => '',
            'youtubeId' => 'not a valid youtube id',
        ]);

        self::assertFalse($form->isValid());
        self::assertSame([
            'time' => [
                Date::FALSEFORMAT => 'The input does not fit the date format \'Y-m-d H:i:s\'',
                Date::INVALID_DATE => 'The input does not appear to be a valid date',
            ],
            'speaker' => [
                InArray::NOT_IN_ARRAY => 'The input was not found in the haystack',
            ],
            'title' => [
                NotEmpty::IS_EMPTY => 'Value is required and can\'t be empty',
            ],
            'youtubeId' => [
                Regex::NOT_MATCH => 'YouTube video IDs must consist of 11 alphanumeric characters with - or _',
            ],
        ], $form->getMessages());
    }

    public function testValidationSuccess()
    {
        $speaker = Speaker::fromNameAndTwitter('Foo Bar', 'footweets');

        $speakers = $this->createMock(GetAllSpeakersInterface::class);
        $speakers->expects(self::once())->method('__invoke')->willReturn([$speaker]);

        $form = new TalkForm($speakers);
        $form->getInputFilter()->remove('talkForm_csrf');

        $form->setData([
            'time' => [
                'year' => '2016',
                'month' => '12',
                'day' => '31',
                'hour' => '23',
                'minute' => '59',
            ],
            'speaker' => $speaker->getId(),
            'title' => 'Some talk title is good',
            'abstract' => 'A little bit about the talk helps to describe it',
            'youtubeId' => 'stVnFCyDyeY',
        ]);

        self::assertTrue($form->isValid());
        self::assertSame([], $form->getMessages());
    }
}
