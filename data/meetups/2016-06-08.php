<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - June 2016 Meetup';
$eid = '25051234918';
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
As software developers, we are in great demand. There are lots of companies out there looking for good developers, but how do we know what companies are good to work for?
We will look into how to set yourself up for the interview as a candidate, and what signs to look for. There is a clear list of indicators and questions we should ask, that will give us a clear understanding of the way a company is organised.
But what happens if a developer has to be the one conducting the interview?
Here we will switch things around, as we will go through the way the interviews should be conducted from the interviewer side. We will see what questions to ask, and how to gauge the answers from the candidate. We will look into how to structure the interview, and what techniques to use.
Finally we will go over some of the interview basics and how to navigate the usual pitfalls of the job marketplace.
Overall by following these steps, we should make the job hunt easier, and more pleasurable for all involved.
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2016-06-08 19:00'))
    ->setToDate(new DateTime('2016-06-08 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
    	'Lightning talk - tbc',
    	new TalkEntity('Stanko Markovic', 'greyshirt', 'How to do interviews properly - look from both sides', $abstract),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
		'A year PhpStorm license prize, courtesy of JetBrains',
    ))
	->setSchedule(array(
		new ScheduleEntity(new \DateTime('19:00'), 'Arrival with beer and pizza'),
		new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
		new ScheduleEntity(new \DateTime('19:30'), 'TBC'),
		new ScheduleEntity(new \DateTime('19:40'), 'Stanko Markovic'),
		new ScheduleEntity(new \DateTime('20:40'), 'Closing comments'),
		new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
	))
    ->setWidget($eventbriteWidget);

return $meetup;
