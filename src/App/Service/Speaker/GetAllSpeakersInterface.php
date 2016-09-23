<?php
declare(strict_types = 1);

namespace App\Service\Speaker;

use App\Entity\Speaker;

interface GetAllSpeakersInterface
{
    /**
     * Return all Speakers. Returns an empty array if there none exist.
     * @return Speaker[]
     */
    public function __invoke() : array;
}
