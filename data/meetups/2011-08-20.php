<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
	->setDate(new DateTime('2011-08-20 14:00'))
	->setLocation('The Deco, Portsmouth')
	->setTopic('GoDeploy and Git')
	->setTalkingPoints(array(
		'GoDeploy issues',
		'Git usage',
	));

return $meetup;