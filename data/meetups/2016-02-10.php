<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - February 2016 Meetup';
$eid = '19379886763';
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
A good rule of thumb to have as a developer is that if you have to do something three times or more, you should automate it.<br />
<br />
Imagine that a task takes you a minute to do, twice a day. Now imagine that you could write something that does it for you, but it would take an hour. Initially, you'll have lost an hour, but after the first month you'll be breaking even, as you've saved those two minutes per day. Then after the second month, you've essentially gained a free hour.<br />
<br />
Automation is a developer's best friend. Some things are easier to automate than others, but almost anything can be automated. In this talk, we'll take a look at what can be automated, what tools are available to help us and crucially, ​*if*​ we should automate it. Surprisingly, sometimes the answer to the question "should we?" is "no".
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2016-02-10 19:00'))
    ->setToDate(new DateTime('2016-02-10 23:00'))
    ->setRegistrationUrl("http://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
    	new TalkEntity('Michael Heap', 'mheap', 'Automation Automation Automation', $abstract),
        '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
    ))
	->setSchedule(array(
		new ScheduleEntity(new \DateTime('19:00'), 'Arrival'),
		new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
		new ScheduleEntity(new \DateTime('19:30'), 'Michael Heap'),
		new ScheduleEntity(new \DateTime('20:30'), 'Closing comments'),
		new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
	))
    ->setWidget($eventbriteWidget);

return $meetup;
