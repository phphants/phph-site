<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - December 2015 Meetup';
$eid = '16783320363';
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
While built for the web, PHP doesn't abstract the actual HTTP messages. The new PSR-7 specification defines these, allowing you to code to shared interfaces instead of specific frameworks. Additionally, strong, shared HTTP abstractions give rise to a concept called "Middleware," software that sits between a request and a response. Come discover how PSR-7 works, learn about common middleware patterns, and discover how the two will change how you develop in PHP!
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2015-12-09 19:00'))
    ->setToDate(new DateTime('2015-12-09 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
    	new TalkEntity('Matthew Weier O\'Phinney', 'mwop', 'PSR-7 and Middleware: The Future of PHP', $abstract),
        'Super Special Xmas Prize Draws!',
        'Mince pies and yule logs!',
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
    ))
	->setSchedule(array(
		new ScheduleEntity(new \DateTime('19:00'), 'Arrival'),
		new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
		new ScheduleEntity(new \DateTime('19:30'), 'Matthew Weier O\'Phinney'),
		new ScheduleEntity(new \DateTime('20:30'), 'Closing comments'),
		new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
	))
    ->setWidget($eventbriteWidget);

return $meetup;
