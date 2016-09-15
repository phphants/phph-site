<?php

use App\Entity\Meetup;
use App\Entity\Talk;
use App\Entity\Schedule;

$etitle = 'PHP Hampshire - September Meetup';
$eid = '7896441469';
$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="https://www.eventbrite.co.uk/tickets-external?eid=' . $eid . '&ref=etckt&v=2" frameborder="0" height="214" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/event/' . $eid . '?ref=etckt">' . $etitle . '</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2013-09-11 19:00'))
    ->setToDate(new DateTimeImmutable('2013-09-11 21:30'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NH&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NH,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis Conference Centre, Arundel Street, PO1 1NH')
    ->setTalkingPoints(array(
        new Talk('Michael Cullum', 'michaelcullumuk', 'PHP FIG: Standardising PHP'),
        new Talk('James Titcumb', 'asgrim', 'Lightning Talk - Composer'),
    ))
    ->setSchedule(array(
        new Schedule(new \DateTimeImmutable('19:00'), 'Arrival'),
        new Schedule(new \DateTimeImmutable('19:20'), 'Welcome announcement'),
        new Schedule(new \DateTimeImmutable('19:30'), 'Michael Cullum (PHP FIG: Standardising PHP)'),
        new Schedule(new \DateTimeImmutable('20:30'), 'Break'),
        new Schedule(new \DateTimeImmutable('20:40'), 'Lightning Talk - Composer'),
        new Schedule(new \DateTimeImmutable('20:50'), 'Closing Comments'),
        new Schedule(new \DateTimeImmutable('21:00'), 'Social Gathering at <a href="http://brewhouseandkitchen.com/">Brewhouse Pompey</a>'),
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
