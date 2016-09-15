<?php

use App\Entity\Meetup;
use App\Entity\Talk;
use App\Entity\Schedule;

$etitle = 'PHP Hampshire - December 2014 Meetup';
$eid = '13601216605';
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
Twitter is a global, real-time platform; an indispensable companion to life in the moment and what’s happening in the world at any given time. The Twitter APIs and platform give developers the opportunity to tap into the pulse of the planet and use that data in innovative ways. This talk will provide some examples, and look at how to take advantage of the platform through Twitter APIs.
END;

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2014-12-10 19:00'))
    ->setToDate(new DateTimeImmutable('2014-12-10 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
    	new Talk('Andy Piper', 'andypiper', 'Connecting to the Pulse of the Planet', $abstract),
        'Super Special Xmas Prize Draws - with prizes from <strong>Spectrum IT, GitHub, php|architect, JetBrains, O\'Reilly &amp; more</strong>!',
        'elePHPant Raffles!',
        'Mince pies and yule logs!',
    	'9pm Social @ Brewhouse Pompey (The White Swan)',
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
