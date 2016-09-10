<?php

use Phph\Site\Model\MeetupEntity;

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setFromDate(new DateTime('2011-10-08 12:00'))
    ->setLocation('Private location')
    ->setTopic('Existing projects')
    ->setTalkingPoints(array(
        'ZF documentation and best practise',
        'Work on GoDeploy',
    ));

return $meetup;
