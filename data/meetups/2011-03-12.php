<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setFromDate(new DateTime('2011-03-12 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('Plan for the group')
    ->setTalkingPoints(array(
        'Set up a MediaWiki for planning',
        'Decided on monthly meetups',
    ));

return $meetup;
