<?php
declare(strict_types = 1);

namespace AppTest\Form\Account;

use App\Form\Account\SpeakerForm;
use Zend\Diactoros\Stream;
use Zend\Diactoros\UploadedFile;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\File;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Validator\NotEmpty;

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
        self::assertInstanceOf(Textarea::class, $form->get('biography'));
        self::assertInstanceOf(File::class, $form->get('imageFilename'));
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
            'biography' => ' foo<bar>baz ',
            'imageFilename' => null,
        ]);

        $form->isValid();

        self::assertSame([
            'name' => 'foobaz',
            'twitter' => 'foobaz',
            'biography' => 'foobaz',
            'imageFilename' => null,
        ], $form->getData());
    }

    public function testValidationFailureWithMessages()
    {
        $form = new SpeakerForm();
        $form->getInputFilter()->remove('speakerForm_csrf');

        $form->setData([
            'name' => '',
            'twitter' => '', // note, twitter handle not required, so no validation messages here
            'biography' => '',
        ]);

        self::assertFalse($form->isValid());
        self::assertSame([
            'name' => [
                NotEmpty::IS_EMPTY => 'Value is required and can\'t be empty',
            ],
            'biography' => [
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
            'biography' => 'This is some biography text...',
        ]);

        self::assertTrue($form->isValid());
        self::assertSame([], $form->getMessages());
    }

    public function testSetDataWithUploadedFilesWithValidUploadedFile()
    {
        $testStream = new Stream('php://memory');
        $uploadedFile = new UploadedFile($testStream, 1000, 0);

        /** @var SpeakerForm|\PHPUnit_Framework_MockObject_MockObject $form */
        $form = $this->getMockBuilder(SpeakerForm::class)
            ->setMethods(['setData'])
            ->getMock();
        $form->expects(self::once())->method('setData')->with([
            'name' => 'Foo Bar',
            'twitter' => 'foobar',
            'biography' => 'This is some biography text...',
            'imageFilename' => [
                'tmp_name' => 'php://memory',
                'name' => null,
                'type' => null,
                'size' => 1000,
                'error' => 0,
            ],
        ])->willReturn($form);
        $form->setDataWithUploadedFiles(
            [
                'name' => 'Foo Bar',
                'twitter' => 'foobar',
                'biography' => 'This is some biography text...',
            ],
            [
                'imageFilename' => $uploadedFile,
            ]
        );
    }

    public function testSetDataWithUploadedFilesWithInvalidStream()
    {
        $uploadedFile = new UploadedFile('[arg is ignored as error is 4]', 1000, 4);

        /** @var SpeakerForm|\PHPUnit_Framework_MockObject_MockObject $form */
        $form = $this->getMockBuilder(SpeakerForm::class)
            ->setMethods(['setData'])
            ->getMock();
        $form->expects(self::once())->method('setData')->with([
            'name' => 'Foo Bar',
            'twitter' => 'foobar',
            'biography' => 'This is some biography text...',
            'imageFilename' => [
                'tmp_name' => null,
                'name' => null,
                'type' => null,
                'size' => 1000,
                'error' => 4,
            ],
        ])->willReturn($form);
        $form->setDataWithUploadedFiles(
            [
                'name' => 'Foo Bar',
                'twitter' => 'foobar',
                'biography' => 'This is some biography text...',
            ],
            [
                'imageFilename' => $uploadedFile,
            ]
        );
    }
}
