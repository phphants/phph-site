<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - October 2015 Meetup';
$eid = '16783278237';
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
OWASP Top Ten Risks is one of the most cited documents and describes the top 10 critical security vulnerabilities. In order to prevent them, developers must be aware of the controls they can incorporate in the early stages of software development lifecycle.<br />
<br />
To help this process, OWASP Top Ten Proactive Controls has been created. This is a list of security techniques that should be included in every software development project. The talk presents each control and then maps them to the OWASP risks they help preventing.
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2015-10-14 19:00'))
    ->setToDate(new DateTime('2015-10-14 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
    	new TalkEntity('Katy Anton', 'KatyAnton', 'OWASP Proactive controls for developers - how to prevent the Top 10 Risks', $abstract),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
    ))
	->setSchedule(array(
		new ScheduleEntity(new \DateTime('19:00'), 'Arrival'),
		new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
		new ScheduleEntity(new \DateTime('19:30'), 'Katy Anton - OWASP Proactive controls for developers'),
		new ScheduleEntity(new \DateTime('20:30'), 'Closing comments'),
		new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
	))
    ->setWidget($eventbriteWidget);

return $meetup;
