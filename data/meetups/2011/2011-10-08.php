<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-10-08 12:00'))
    ->setLocation('Private location')
    ->setTopic('Existing projects')
    ->setTalkingPoints(array(
        'ZF documentation and best practise',
        'Work on GoDeploy',
    ));

return $meetup;
