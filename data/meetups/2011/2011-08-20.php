<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-08-20 14:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('GoDeploy and Git')
    ->setTalkingPoints(array(
        'GoDeploy issues',
        'Git usage',
    ));

return $meetup;
