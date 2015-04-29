<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - November 2014 Meetup';
$eid = '13586326067';
$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="http://www.eventbrite.co.uk/tickets-external?eid=' . $eid . '&ref=etckt&v=2" frameborder="0" height="240" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk/event/' . $eid . '?ref=etckt">' . $etitle . '</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new MeetupEntity();

$abstract = <<<END
When you have a huge website and you decide to make the move to Symfony, it can be a very daunting prospect of having to rewrite your entire website on top of the Symfony framework. We’ll go through how this can be done as smoothly as possible with a large enterprise size website, piece by piece, deploying your site every step of the way, following along with the example of phpBB, an organisation going through this process, to discover the right and wrong way to go about it and many tools you can use on enterprise-scale Symfony applications to help along the way.
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2014-11-12 19:00'))
    ->setToDate(new DateTime('2014-11-12 23:00'))
    ->setRegistrationUrl("http://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NH&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NH,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NH')
    ->setTalkingPoints(array(
    	new TalkEntity('Michael Cullum', 'michaelcullumuk', 'Converting a website to a new religion: Symfony', $abstract),
    	'9pm Social @ Brewhouse Pompey (The White Swan)',
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
