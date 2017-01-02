<?php
declare(strict_types = 1);

namespace App\Service\Speaker;

use Psr\Http\Message\UploadedFileInterface;

interface MoveSpeakerHeadshotInterface
{
    /**
     * Move the uploaded file to a predetermined location and return the filename
     *
     * @param UploadedFileInterface $uploadedFile
     * @return string
     */
    public function __invoke(UploadedFileInterface $uploadedFile) : string;
}
