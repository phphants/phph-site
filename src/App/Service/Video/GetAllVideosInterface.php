<?php
declare(strict_types = 1);

namespace App\Service\Video;

use App\Entity\Video;

interface GetAllVideosInterface
{
    /**
     * Return all Videos. Returns an empty array if none exist.
     * @return Video[]
     */
    public function __invoke() : array;
}
