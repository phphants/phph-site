<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-06-04 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('More Zend Framework')
    ->setTalkingPoints(array(
        'Minecraft',
        'ZF View Helpers',
        'Pagoda Box and scalable cloud PHP hosting',
        'Ideas for collaborative projects e.g. Pompey Music Forum',
        'PHP extensions in C',
    ));

return $meetup;
