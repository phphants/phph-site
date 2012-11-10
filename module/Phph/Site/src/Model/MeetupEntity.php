<?php

namespace Phph\Site\Model;

class MeetupEntity
{
	protected $id;
	protected $date;
	protected $location;
	protected $topic;
	protected $talkingPoints;

	public function exchangeArray($data)
	{
		throw new \Exception("Not implemented yet...");
	}

	public function setId($id)
	{
		$this->id = (int)$id;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	public function setDate(\DateTime $date)
	{
		$this->date = $date;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	public function setLocation($location)
	{
		$this->location = (string)$location;
		return $this;
	}

	public function getLocation()
	{
		return $this->location;
	}

	public function setTopic($topic)
	{
		$this->topic = (string)$topic;
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
}