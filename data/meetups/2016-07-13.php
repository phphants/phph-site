<?php

use App\Entity\Meetup;
use App\Entity\Talk;
use App\Entity\Schedule;

$etitle = 'PHP Hampshire - July 2016 Meetup';
$eid = '25051456581';
$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="https://www.eventbrite.co.uk/tickets-external?eid=' . $eid . '&ref=etckt&v=2" frameborder="0" height="240" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/event/' . $eid . '?ref=etckt">' . $etitle . '</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new Meetup();

$abstract = <<<END
Docker, the hottest technology around at the moment. It swept the Ops world by storm in 2014, became mainstream in 2015, and now it’s set to dominate the developer world, in 2016.
Docker is a tool that allows you to package your application up into a single-runnable distributable binary - akin to the phar, but in Hulk mode. Docker allows you, a developer, to specify the exact environment your application needs to run, across development; test; staging; and production.
In this talk I will cover the creation of this utopian distributable and show you how you can compose your entire production infrastructure locally with only a small YAML file and without installing a single thing.
Lets say hello, to Docker.
END;

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2016-07-13 19:00'))
    ->setToDate(new DateTimeImmutable('2016-07-13 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
        new Talk('David McKay', 'rawkode', 'Kickass Development Environments with Docker', $abstract),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
        'A year PhpStorm license prize, courtesy of JetBrains',
    ))
    ->setSchedule(array(
        new Schedule(new \DateTimeImmutable('19:00'), 'Arrival with beer and pizza'),
        new Schedule(new \DateTimeImmutable('19:25'), 'Welcome announcement'),
        new Schedule(new \DateTimeImmutable('19:30'), 'David McKay'),
        new Schedule(new \DateTimeImmutable('20:40'), 'Closing comments'),
        new Schedule(new \DateTimeImmutable('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
