<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-11-19 12:00'))
    ->setLocation('Private location')
    ->setTopic('GoDeploy roadmap')
    ->setTalkingPoints(array(
        'Monetisation of GoDeploy',
    ));

return $meetup;
