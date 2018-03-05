<?php
declare(strict_types = 1);

namespace App\Service\Speaker;

use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;

final class FlysystemMoveSpeakerHeadshot implements MoveSpeakerHeadshotInterface
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritDoc}
     * @throws \League\Flysystem\FileExistsException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __invoke(UploadedFileInterface $uploadedFile): string
    {
        switch ($uploadedFile->getClientMediaType()) {
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/gif':
                $extension = 'gif';
                break;
            default:
                $extension = 'jpg';
        }
        $filename = (string)Uuid::uuid4() . '.' . $extension;
        $this->filesystem->write(
            $filename,
            $uploadedFile->getStream()->getContents(),
            [
                'ACL' => 'public-read',
            ]
        );
        return $filename;
    }
}
