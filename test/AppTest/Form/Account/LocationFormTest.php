<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\LocationForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;

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
}
