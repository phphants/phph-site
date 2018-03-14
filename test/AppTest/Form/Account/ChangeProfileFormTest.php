<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\ChangeProfileForm;
use App\Validator\UserDoesNotExistValidator;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Validator\ValidatorInterface;

/**
 * @covers \App\Form\Account\ChangeProfileForm
 */
final class ChangeProfileFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $userExistsValidator;

    /**
     * @var ChangeProfileForm
     */
    private $form;

    public function setUp(): void
    {
        $this->userExistsValidator = $this->createMock(ValidatorInterface::class);

        $this->form = new ChangeProfileForm($this->userExistsValidator);
    }

    public function testFormHasExpectedFields(): void
    {
        self::assertInstanceOf(Text::class, $this->form->get('name'));
        self::assertInstanceOf(Text::class, $this->form->get('email'));
        self::assertInstanceOf(Submit::class, $this->form->get('submit'));
        self::assertInstanceOf(Csrf::class, $this->form->get('changeProfileForm_csrf'));
    }

    public function testValidationForEmptySubmission(): void
    {
        $this->form->getInputFilter()->remove('changeProfileForm_csrf');
        $this->form->getInputFilter()->remove('submit');

        $this->form->setData([
            'name' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
        ]);

        self::assertFalse($this->form->isValid());
        self::assertEquals(
            [
                'name' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
                'email' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
            ],
            $this->form->getMessages()
        );
    }

    public function testValidationForInvalidSubmission(): void
    {
        $this->userExistsValidator->expects(self::once())->method('isValid')->willReturn(false);
        $this->userExistsValidator->expects(self::once())->method('getMessages')->willReturn([
            UserDoesNotExistValidator::USER_EXISTS => 'A user with this email already exists.',
        ]);
        $this->form->getInputFilter()->remove('changeProfileForm_csrf');
        $this->form->getInputFilter()->remove('submit');

        $this->form->setData([
            'name' => '',
            'email' => uniqid('not a valid email', true),
        ]);

        self::assertFalse($this->form->isValid());
        self::assertEquals(
            [
                'name' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
                'email' => [
                    'emailAddressInvalidFormat'
                        => 'The input is not a valid email address. Use the basic format local-part@hostname',
                    'userExists' => 'A user with this email already exists.',
                ],
            ],
            $this->form->getMessages()
        );
    }

    public function testValidationForValidSubmission(): void
    {
        $this->userExistsValidator->expects(self::once())->method('isValid')->willReturn(true);
        $this->form->getInputFilter()->remove('changeProfileForm_csrf');
        $this->form->getInputFilter()->remove('submit');

        $this->form->setData([
            'name' => uniqid('My Name', true),
            'email' => 'valid@email.com',
        ]);

        self::assertTrue($this->form->isValid());
        self::assertEquals([], $this->form->getMessages());
    }
}
