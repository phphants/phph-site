<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\MeetupForm;
use App\Service\Location\GetAllLocationsInterface;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;

/**
 * @covers \App\Form\Account\MeetupForm
 */
final class MeetupFormTest extends \PHPUnit_Framework_TestCase
{
    public function testFormHasExpectedFields()
    {
        $locations = $this->createMock(GetAllLocationsInterface::class);
        $locations->expects(self::once())->method('__invoke')->willReturn([]);

        $form = new MeetupForm($locations);

        self::assertInstanceOf(DateTime::class, $form->get('from'));
        self::assertInstanceOf(DateTime::class, $form->get('to'));
        self::assertInstanceOf(Select::class, $form->get('location'));
        self::assertInstanceOf(Submit::class, $form->get('submit'));
        self::assertInstanceOf(Csrf::class, $form->get('meetupForm_csrf'));
    }
}
