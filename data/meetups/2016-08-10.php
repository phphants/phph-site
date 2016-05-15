<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - August 2016 Meetup';
$eid = '25377661268';
$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="https://www.eventbrite.co.uk/tickets-external?eid=' . $eid . '&ref=etckt&v=2" frameborder="0" height="240" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/event/' . $eid . '?ref=etckt">' . $etitle . '</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new MeetupEntity();

$abstract = <<<END
Always been interested in the Raspberry Pi but never known what you could do with it? Got a Raspberry Pi at home that you played with for 5 minutes before you got bored? This talk is for you.<br /><br />
We will be making a journey into the world of programming with sensors and other electrical components. The concepts introduced will not be specific to any programming language, but we will use PHP throughout to keep it simple. The demonstration will show how you could use a Raspberry Pi to spice up a home bar.<br /><br />
By the end of this talk, you will have acquired the skills to get started on your own hobby electronics projects! Maybe these skills will one day be handy introducing friends and family to the adventures of programming.
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2016-08-10 19:00'))
    ->setToDate(new DateTime('2016-08-10 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
        'Lightning talk - tbc',
        new TalkEntity('Andrew Carter', 'AndrewCarterUK', 'Drinking Beer with a Raspberry Pi and PHP', $abstract),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
        'A year PhpStorm license prize, courtesy of JetBrains',
    ))
    ->setSchedule(array(
        new ScheduleEntity(new \DateTime('19:00'), 'Arrival with beer and pizza'),
        new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
        new ScheduleEntity(new \DateTime('19:30'), 'TBC'),
        new ScheduleEntity(new \DateTime('19:40'), 'Andrew Carter'),
        new ScheduleEntity(new \DateTime('20:40'), 'Closing comments'),
        new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
