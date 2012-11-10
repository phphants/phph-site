<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
	->setDate(new DateTime('2012-04-21 12:00'))
	->setLocation('The Deco, Portsmouth')
	->setTopic('Gearman')
	->setTalkingPoints(array(
		'Talked about Gearman in depth',
		'Raytracing vs polygon rendering in 3D',
	));

return $meetup;