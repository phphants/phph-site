<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-04-16 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('Zend Framework Introduction')
    ->setTalkingPoints(array(
        'Decided on group name PHP Hampshire',
        'Logo redesigned with lightning',
        'Talked about possibility of setting up a mailing list',
        'Zend Framework 1 introduction',
        'PHP additions - closures, goto, etc.',
    ));

return $meetup;
