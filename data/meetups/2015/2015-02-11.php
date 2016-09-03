<?php

use App\Entity\Meetup;
use App\Entity\Talk;
use App\Entity\Schedule;

$etitle = 'PHP Hampshire - February 2015 Meetup';
$eid = '15348702382';
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
A summary of successful testing for business platforms mostly built with PHP.  The return on investment for testing  Many of these are network services, and all require high levels of uptime.  The practices of TDD and BDD are discussed; and realistic scenarios walked through.  I will branch out into related areas such as CI depending on time used.  Material covered should be standard practice for professional developers.
END;

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2015-02-11 19:00'))
    ->setToDate(new DateTimeImmutable('2015-02-11 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
    	new Talk('Owen Beresford', 'ChannelOwen', 'Test Strategies &amp;&amp; Process', $abstract),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
        '9pm Social @ Brewhouse Pompey (The White Swan)',
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
