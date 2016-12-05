<?php
declare(strict_types = 1);

namespace App\Service\Speaker;

use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;

class MoveSpeakerHeadshot implements MoveSpeakerHeadshotInterface
{
    /**
     * @var string
     */
    private $headshotDirectory;

    public function __construct(string $headshotDirectory)
    {
        $this->headshotDirectory = $headshotDirectory;
    }

    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __invoke(UploadedFileInterface $uploadedFile): string
    {
        $filename = (string)Uuid::uuid4();
        $uploadedFile->moveTo($this->headshotDirectory . $filename);
        return $filename;
    }
}
