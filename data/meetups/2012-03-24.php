<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setDate(new DateTime('2012-03-24 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('PHP extensions')
    ->setTalkingPoints(array(
        'Basic PHP extensions (using C)',
        'Gearman introduction',
    ));

return $meetup;
