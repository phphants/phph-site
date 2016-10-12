<?php
declare(strict_types = 1);

namespace App\Service\Talk;

use App\Entity\Talk;

interface FindTalksWithVideoInterface
{
    /**
     * @return Talk[]
     */
    public function __invoke() : array;
}
