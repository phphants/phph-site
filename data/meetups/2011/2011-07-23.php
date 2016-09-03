<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-07-23 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('GoDeploy')
    ->setTalkingPoints(array(
        'Discussed GoDeploy and distribution of jobs',
        'Javascript Frameworks - Dojo, JQuery, Prototype+Scriptaculous',
        'Tablets (e.g. Samsung Galaxy Tabs)',
    ));

return $meetup;
