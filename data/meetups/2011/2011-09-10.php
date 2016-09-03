<?php

use App\Entity\Meetup;

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2011-09-10 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('GoDeploy')
    ->setTalkingPoints(array(
        'GoDeploy outstanding bugs and new features',
        'Zend Certification Examination',
        'Should GoDeploy support Windows servers',
        'How git flow could help GoDeploy',
    ));

return $meetup;
