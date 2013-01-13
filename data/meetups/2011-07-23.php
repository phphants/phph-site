<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setFromDate(new DateTime('2011-07-23 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('GoDeploy')
    ->setTalkingPoints(array(
        'Discussed GoDeploy and distribution of jobs',
        'Javascript Frameworks - Dojo, JQuery, Prototype+Scriptaculous',
        'Tablets (e.g. Samsung Galaxy Tabs)',
    ));

return $meetup;
