<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
	->setDate(new DateTime('2011-06-04 12:00'))
	->setLocation('The Deco, Portsmouth')
	->setTopic('More Zend Framework')
	->setTalkingPoints(array(
		'Minecraft',
		'ZF View Helpers',
		'Pagoda Box and scalable cloud PHP hosting',
		'Ideas for collaborative projects e.g. Pompey Music Forum',
		'PHP extensions in C',
	));

return $meetup;