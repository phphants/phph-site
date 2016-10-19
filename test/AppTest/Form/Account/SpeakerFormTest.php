<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\SpeakerForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Validator\NotEmpty;
use Zend\Validator\Uri;

/**
 * @covers \App\Form\Account\SpeakerForm
 */
final class SpeakerFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $form = new SpeakerForm();

        self::assertInstanceOf(Text::class, $form->get('name'));
        self::assertInstanceOf(Text::class, $form->get('twitter'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('speakerForm_csrf'));
    }

    public function testFilteringOnFields()
    {
        $form = new SpeakerForm();
        $form->getInputFilter()->remove('speakerForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'name' => ' foo<bar>baz ',
            'twitter' => ' foo<bar>baz ',
        ]);

        $form->isValid();

        self::assertSame([
            'name' => 'foobaz',
            'twitter' => 'foobaz',
        ], $form->getData());
    }

    public function testValidationFailureWithMessages()
    {
        $form = new SpeakerForm();
        $form->getInputFilter()->remove('speakerForm_csrf');

        $form->setData([
            'name' => '',
            'twitter' => '', // note, twitter handle not required, so no validation messages here
        ]);

        self::assertFalse($form->isValid());
        self::assertSame([
            'name' => [
                NotEmpty::IS_EMPTY => 'Value is required and can\'t be empty',
            ],
        ], $form->getMessages());
    }

    public function testValidationSuccess()
    {
        $form = new SpeakerForm();
        $form->getInputFilter()->remove('speakerForm_csrf');

        $form->setData([
            'name' => 'Foo Bar',
            'twitter' => 'foobar',
        ]);

        self::assertTrue($form->isValid());
        self::assertSame([], $form->getMessages());
    }
}
