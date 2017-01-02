<?php
declare(strict_types = 1);

namespace AppTest\Service\Talk;

use App\Service\Speaker\MoveSpeakerHeadshot;
use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Speaker\MoveSpeakerHeadshot
 */
class MoveSpeakerHeadshotTest extends \PHPUnit_Framework_TestCase
{
    public function testMovesFileUsingUploadedFile()
    {
        $imagePath = uniqid('/my/directory', true) . '/';

        $uploadedFile = $this->createMock(UploadedFileInterface::class);
        $uploadedFile->expects(self::once())
            ->method('moveTo')
            ->with(
                self::callback(function ($destination) use ($imagePath) {
                    self::assertStringStartsWith($imagePath, $destination);
                    return true;
                })
            );

        self::assertTrue(Uuid::isValid((new MoveSpeakerHeadshot($imagePath))->__invoke($uploadedFile)));
    }
}
