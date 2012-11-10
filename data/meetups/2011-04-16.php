<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
	->setDate(new DateTime('2011-04-16 12:00'))
	->setLocation('The Deco, Portsmouth')
	->setTopic('Zend Framework Introduction')
	->setTalkingPoints(array(
		'Decided on group name PHP Hampshire',
		'Logo redesigned with lightning',
		'Talked about possibility of setting up a mailing list',
		'Zend Framework 1 introduction',
		'PHP additions - closures, goto, etc.',
	));

return $meetup;