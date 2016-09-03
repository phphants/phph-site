<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2013-01-10 18:00'))
    ->setLocation('The Red Lion, Horndean')
    ->setTopic('Prerequisite knowledge for working with ZF2')
    ->setTalkingPoints(array(
        'Tools and skills that Zend assumes you have before you start with ZF2',
        'Other tools people currently use in development',
        'Getting to meet other developers',
    ));

return $meetup;
