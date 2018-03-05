<?php
declare(strict_types = 1);

namespace AppTest\Service\Talk;

use App\Service\Speaker\FlysystemMoveSpeakerHeadshot;
use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Speaker\FlysystemMoveSpeakerHeadshot
 */
class FlysystemMoveSpeakerHeadshotTest extends \PHPUnit_Framework_TestCase
{
    public function uploadedFileProvider()
    {
        return  [
            ['image/png', 'png'],
            ['image/gif', 'gif'],
            ['image/jpeg', 'jpg'],
            ['text/plain', 'jpg'],
            ['sheep/cow', 'jpg'],
        ];
    }

    /**
     * @param string $contentType
     * @param string $expectedExtension
     * @throws \League\Flysystem\FileExistsException
     * @dataProvider uploadedFileProvider
     */
    public function testMovesFileUsingUploadedFile(string $contentType, string $expectedExtension): void
    {
        $imageFileContent = uniqid('imageFileContent', true);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())->method('getContents')->willReturn($imageFileContent);

        $uploadedFile = $this->createMock(UploadedFileInterface::class);
        $uploadedFile->expects(self::once())->method('getStream')->willReturn($stream);
        $uploadedFile->expects(self::any())->method('getClientMediaType')->willReturn($contentType);

        $filesystem = $this->createMock(FilesystemInterface::class);
        $filesystem->expects(self::once())
            ->method('write')
            ->with(
                self::callback(function ($filename) use ($expectedExtension) {
                    [$uuid, $extension] = explode('.', $filename);

                    self::assertTrue(Uuid::isValid($uuid));
                    self::assertSame($expectedExtension, $extension);
                    return true;
                }),
                $imageFileContent,
                [
                    'ACL' => 'public-read',
                ]
            );

        /** @noinspection ImplicitMagicMethodCallInspection */
        self::assertNotEmpty((new FlysystemMoveSpeakerHeadshot($filesystem))->__invoke($uploadedFile));
    }
}
