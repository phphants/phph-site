<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-03-12 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('Plan for the group')
    ->setTalkingPoints(array(
        'Set up a MediaWiki for planning',
        'Decided on monthly meetups',
    ));

return $meetup;
