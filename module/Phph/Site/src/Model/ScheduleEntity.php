<?php

namespace Phph\Site\Model;

class ScheduleEntity
{
    protected $time;
    protected $item;

    public function __construct(\DateTime $time, $item)
    {
        $this->time = $time;
        $this->item = $item;
    }

    public function __toString()
    {
        $s = '<strong>' . $this->getTime()->format('H:i') . '</strong> &mdash; ' . $this->getItem();

        return $s;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getItem()
    {
        return $this->item;
    }
}
