<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2012-03-24 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('PHP extensions')
    ->setTalkingPoints(array(
        'Basic PHP extensions (using C)',
        'Gearman introduction',
    ));

return $meetup;
