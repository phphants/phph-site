<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - October 2016 Meetup';
$eid = '27489285192';
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
Do you feel like you're faking it? like you don't feel good enough to do your job? Feeling like you've blagged your way through your career? Then like me and hundreds of others, you might be suffering from imposter syndrome.
During my talk I am going to discuss what imposter syndrome is and how it feels. Then I'm going to talk you through why people suffer from it and how people overcome it.
This talk is based on both my personal experiences and those of others. By the end of it I hope you can identify if you are suffering from imposter syndrome and also create a team environment that helps to combat the feeling within your team mates.
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2016-10-12 19:00'))
    ->setToDate(new DateTime('2016-10-12 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
        new TalkEntity('James Titcumb', 'asgrim', '5 minute lightning talk'),
        new TalkEntity('Mark Bradley', 'braddle', 'Imposter Syndrome: Am I Faking It?', nl2br($abstract)),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
        'A year PhpStorm license prize, courtesy of JetBrains',
    ))
    ->setSchedule(array(
        new ScheduleEntity(new \DateTime('19:00'), 'Arrival with beer and pizza'),
        new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
        new ScheduleEntity(new \DateTime('19:30'), 'James Titcumb'),
        new ScheduleEntity(new \DateTime('19:40'), 'Mark Bradley'),
        new ScheduleEntity(new \DateTime('20:40'), 'Closing comments'),
        new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
