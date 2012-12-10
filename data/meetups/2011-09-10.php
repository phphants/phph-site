<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setDate(new DateTime('2011-09-10 12:00'))
    ->setLocation('The Deco, Portsmouth')
    ->setTopic('GoDeploy')
    ->setTalkingPoints(array(
        'GoDeploy outstanding bugs and new features',
        'Zend Certification Examination',
        'Should GoDeploy support Windows servers',
        'How git flow could help GoDeploy',
    ));

return $meetup;
