<?php

namespace Phph\Site\Model;

class MeetupEntity
{
    protected $id;
    protected $fromDate;
    protected $toDate;
    protected $registrationUrl;
    protected $locationUrl;
    protected $location;
    protected $topic;
    protected $talkingPoints;
    protected $widget;

    public function exchangeArray($data)
    {
        throw new \Exception("Not implemented yet...");
    }

    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setFromDate(\DateTime $date)
    {
        $this->fromDate = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    public function setToDate(\DateTime $date)
    {
        $this->toDate = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    public function setRegistrationUrl($url)
    {
        $this->registrationUrl = (string) $url;

        return $this;
    }

    public function getRegistrationUrl()
    {
        return $this->registrationUrl;
    }

    public function setLocationUrl($url)
    {
        $this->locationUrl = (string) $url;

        return $this;
    }

    public function getLocationUrl()
    {
        return $this->locationUrl;
    }

    public function setLocation($location)
    {
        $this->location = (string) $location;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setTopic($topic)
    {
        $this->topic = (string) $topic;

        return $this;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTalkingPoints(array $talkingPoints)
    {
        $this->talkingPoints = $talkingPoints;

        return $this;
    }

    public function getTalkingPoints()
    {
        return $this->talkingPoints;
    }

    public function setWidget($widgetString)
    {
        $this->widget = $widgetString;

        return $this;
    }

    public function getWidget()
    {
        return $this->widget;
    }
}
