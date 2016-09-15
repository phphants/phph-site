<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2012-12-15 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('PHP Hampshire!')
    ->setTalkingPoints(array(
        'How can we spread the word of the group?',
        'Community - what do people think of the site? What improvements can we make?',
        'Popular frameworks - ZF2, Symfony2, Silex etc.',
        'Events',
        'Sponsorship',
    ));

return $meetup;
