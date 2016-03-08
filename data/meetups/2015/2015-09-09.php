<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - September 2015 Meetup';
$eid = '16783273222';
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
Protecting your users' data with just a username and password is no longer satisfactory. Two-factor authentication (2FA) is the primary method of countering the effects of stolen passwords, and it is easy to implement in your web application. In this session, we will discuss what two-factor authentication is, how it works, and the challenges associated with it. We will then look how to integrate two-factor authentication into your PHP application's login workflow. We'll consider a Google Authenticator implementation, so you can make your users' accounts more secure. Finally, we will cover some plugins that WordPress & Drupal developers can use to enable this easily!
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2015-09-09 19:00'))
    ->setToDate(new DateTime('2015-09-09 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
    	new TalkEntity('Rob Allen', 'akrabat', 'Secure your web application with two-factor authentication', $abstract),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
    ))
	->setSchedule(array(
		new ScheduleEntity(new \DateTime('19:00'), 'Arrival'),
		new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
		new ScheduleEntity(new \DateTime('19:30'), 'Rob Allen - Secure your web application with two-factor authentication'),
		new ScheduleEntity(new \DateTime('20:30'), 'Closing comments'),
		new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <del title="Brewhouse is temporarily closed :("><a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)</del> <a href="http://www.jdwetherspoon.co.uk/home/pubs/the-trafalgar">The Trafalgar</a> (Wetherspoons)'),
	))
    ->setWidget($eventbriteWidget);

return $meetup;
