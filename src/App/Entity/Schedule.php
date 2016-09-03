<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

class Schedule
{
    /**
     * @var DateTimeImmutable
     */
    private $time;

    /**
     * @var string
     */
    private $item;

    public function __construct(DateTimeImmutable $time, string $item)
    {
        $this->time = $time;
        $this->item = $item;
    }

    public function __toString() : string
    {
        $s = '<strong>' . $this->getTime()->format('H:i') . '</strong> &mdash; ' . $this->getItem();

        return $s;
    }

    public function getTime() : DateTimeImmutable
    {
        return $this->time;
    }

    public function getItem() : string
    {
        return $this->item;
    }
}
