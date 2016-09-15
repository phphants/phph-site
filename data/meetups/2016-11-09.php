<?php

use App\Entity\Meetup;
use App\Entity\Talk;
use App\Entity\Schedule;

$etitle = 'PHP Hampshire - November 2016 Meetup';
$eid = '27489478771';
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

$abstract = <<<'END'
During 10+ years of teaching PHP I have come to recognise that many introductory-level students find the client-server architecture of server-side web applications confusing and often confuse the programming constructs used to get data from the front-end (e.g. HTML form, query string) and from the database. Beginner students also often fail to appreciate the meaning of code inside a typical loop used to iterate through the results of an SELECT query in PHP.  "EPHP" aims to give students a clearer appreciation of what is actually going on with a typical database-driven PHP application by visualising the components of the application and how they interact. Students can see the data cross the network, and view and edit representations of the HTTP requests and responses live in the browser - as well as clearly see the link between $_GET and $_POST variables and the corresponding form data, and visualise the operation of a typical "while" loop used to visualise database results. The talk will include a demo as well as technical details on how the application is built, and will invite feedback from the audience.
END;

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2016-11-09 19:00'))
    ->setToDate(new DateTimeImmutable('2016-11-09 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
        new Talk('Wade Urry', 'iWader', '5 minute lightning talk'),
        new Talk('Nick Whitelegg', '', 'EPHP: A tool to help students learn the very basics of PHP', nl2br($abstract)),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
        'A year PhpStorm license prize, courtesy of JetBrains',
    ))
    ->setSchedule(array(
        new Schedule(new \DateTimeImmutable('19:00'), 'Arrival with beer and pizza'),
        new Schedule(new \DateTimeImmutable('19:25'), 'Welcome announcement'),
        new Schedule(new \DateTimeImmutable('19:30'), 'Wade Urry'),
        new Schedule(new \DateTimeImmutable('19:40'), 'Nick Whitelegg'),
        new Schedule(new \DateTimeImmutable('20:40'), 'Closing comments'),
        new Schedule(new \DateTimeImmutable('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
