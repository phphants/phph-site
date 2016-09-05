<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

class Meetup
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTimeImmutable
     */
    private $fromDate;

    /**
     * @var DateTimeImmutable
     */
    private $toDate;

    /**
     * @var string
     */
    private $registrationUrl;

    /**
     * @var string
     */
    private $locationUrl;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $topic;

    /**
     * @var array
     */
    private $talkingPoints = [];

    /**
     * @var string
     */
    private $widget;

    /**
     * @var Schedule[]
     */
    private $schedule = [];

    public function __construct()
    {
        $this->schedule = array();
    }

    public function exchangeArray($data) : array
    {
        throw new \Exception('Not implemented yet...');
    }

    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    public function setFromDate(DateTimeImmutable $date) : self
    {
        $this->fromDate = $date;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getFromDate() : DateTimeImmutable
    {
        return $this->fromDate;
    }

    public function setToDate(DateTimeImmutable $date) : self
    {
        $this->toDate = $date;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getToDate() : DateTimeImmutable
    {
        return $this->toDate;
    }

    public function setRegistrationUrl(string $url) : self
    {
        $this->registrationUrl = $url;

        return $this;
    }

    public function getRegistrationUrl() : string
    {
        return $this->registrationUrl;
    }

    public function setLocationUrl(string $url) : self
    {
        $this->locationUrl = $url;

        return $this;
    }

    public function getLocationUrl() : string
    {
        return $this->locationUrl;
    }

    public function setLocation(string $location) : self
    {
        $this->location = $location;

        return $this;
    }

    public function getLocation() : string
    {
        return $this->location;
    }

    public function setTopic(string $topic) : self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTopic()
    {
        return $this->topic;
    }

    public function setTalkingPoints(array $talkingPoints) : self
    {
        // @todo validation
        $this->talkingPoints = $talkingPoints;

        return $this;
    }

    public function getTalkingPoints() : array
    {
        return $this->talkingPoints;
    }

    public function setWidget(string $widgetString) : self
    {
        $this->widget = $widgetString;

        return $this;
    }

    public function getWidget() : string
    {
        return $this->widget;
    }

    public function setSchedule(array $schedule) : self
    {
        // @todo validation
        $this->schedule = $schedule;

        return $this;
    }

    public function getSchedule() : array
    {
        return $this->schedule;
    }
}
