<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\LocationForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Validator\NotEmpty;
use Zend\Validator\Uri;

/**
 * @covers \App\Form\Account\LocationForm
 */
final class LocationFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $form = new LocationForm();

        self::assertInstanceOf(Text::class, $form->get('name'));
        self::assertInstanceOf(Text::class, $form->get('address'));
        self::assertInstanceOf(Text::class, $form->get('url'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('locationForm_csrf'));
    }

    public function testFilteringOnFields()
    {
        $form = new LocationForm();
        $form->getInputFilter()->remove('locationForm_csrf');
        $form->getInputFilter()->remove('submit');

        $form->setData([
            'name' => ' foo<bar>baz ',
            'address' => ' foo<bar>baz ',
            'url' => ' foo<bar>baz ',
        ]);

        $form->isValid();

        self::assertSame([
            'name' => 'foobaz',
            'address' => 'foobaz',
            'url' => 'foobaz',
        ], $form->getData());
    }

    public function testValidationFailureWithMessages()
    {
        $form = new LocationForm();
        $form->getInputFilter()->remove('locationForm_csrf');

        $form->setData([
            'name' => '',
            'address' => '',
            'url' => '?',
        ]);

        self::assertFalse($form->isValid());
        self::assertSame([
            'name' => [
                NotEmpty::IS_EMPTY => 'Value is required and can\'t be empty',
            ],
            'address' => [
                NotEmpty::IS_EMPTY => 'Value is required and can\'t be empty',
            ],
            'url' => [
                Uri::NOT_URI => 'The input does not appear to be a valid Uri',
            ],
        ], $form->getMessages());
    }

    public function testValidationSuccess()
    {
        $form = new LocationForm();
        $form->getInputFilter()->remove('locationForm_csrf');

        $form->setData([
            'name' => 'A nice building',
            'address' => '44 Some Street, Hampshire',
            'url' => 'https://some-nice-building.com/',
        ]);

        self::assertTrue($form->isValid());
        self::assertSame([], $form->getMessages());
    }
}
