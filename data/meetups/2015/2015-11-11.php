<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - November 2015 Meetup';
$eid = '16783286261';
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
The problem is that we, as developers, understand how the web works. This is exaggerated by knowing in even more depth,
how the application/website we are building works. We know how to add a user into a specific group, because we wrote the
code that does it. We understand the intricacies of the systems we build, and often spend so long building them, and
running through cycles of the processes to accomplish certain tasks, that we forget to think about the usability of our
applications.<br />
<br />
Usability is often an after-thought of developers, or it is palmed off to a UI/UX expert. As developers, we need to get
into the mindset of the person who will use the application, not the person who wants the application created, and
incorporate proper usability into more than just form elements and removing all of the sliders that exist.
END;

$abstractPhil = <<<END
How hard is it to get a form right? It's just some standard inputs and a button. Using some "rigorous" user testing
with our "state of the art" user testing equipment we dug into how the default form options and builders on some leading
frameworks went down with the general public. Is taking the easy way out as a developer making it harder for your users?
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2015-11-11 19:00'))
    ->setToDate(new DateTime('2015-11-11 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NP&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NP,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NP')
    ->setTalkingPoints(array(
		    new TalkEntity('Jackson Willis', 'jacksonwillis', 'Using usability to develop your development', $abstract),
		    new TalkEntity('Phil Bennett', 'phil_bennett', 'It\'s a form, how hard can it be?', $abstractPhil),
		    '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT',
	    ))
	->setSchedule(array(
		new ScheduleEntity(new \DateTime('19:00'), 'Arrival'),
		new ScheduleEntity(new \DateTime('19:25'), 'Welcome announcement'),
		new ScheduleEntity(new \DateTime('19:30'), 'Phil Bennett and Jackson Willis'),
		new ScheduleEntity(new \DateTime('20:30'), 'Closing comments'),
		new ScheduleEntity(new \DateTime('20:45'), 'Social gathering at <a href="http://brewhouseandkitchen.com/portsmouth">Brewhouse Pompey</a> (The White Swan)'),
	))
    ->setWidget($eventbriteWidget);

return $meetup;
