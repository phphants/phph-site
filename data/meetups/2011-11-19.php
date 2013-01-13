<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setFromDate(new DateTime('2011-11-19 12:00'))
    ->setLocation('Private location')
    ->setTopic('GoDeploy roadmap')
    ->setTalkingPoints(array(
        'Monetisation of GoDeploy',
    ));

return $meetup;
