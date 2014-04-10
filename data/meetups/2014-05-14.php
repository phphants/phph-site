<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - May 2014 Meetup';
$eid = '10882657321';
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
Over the last few years, the PHP ecosystem's really kicked it up a gear when it comes to good application design, unit testing and dependency management. Unfortunately, some of us are still stuck working with code that's 5 years old and has never heard of dependency injection. How can we use all these wonderful new tricks when our existing codebase is so bad?
<br /><br />
There are ways to do it. Some of them aren't pretty, and some of them feel plain wrong, but they mean that your code is at least a little bit more stable than they were before you started. Over the last 12 months I've been on a mission to improve a legacy code base. This includes eradicating singletons and reducing the dependencies of our unit tests (no need to connect to a DB any more!). Let me help you do the same for your code base too.
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2014-05-14 19:00'))
    ->setToDate(new DateTime('2014-05-14 23:00'))
    ->setRegistrationUrl("http://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NH&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NH,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis Conference Centre, Arundel Street, PO1 1NH')
    ->setTalkingPoints(array(
        new TalkEntity('Michael Heap', 'mheap', 'Bring Your Application Into 2014', $abstract),
        'Lightning talk - tbc',
        '9pm Social @ Brewhouse Pompey (The White Swan)',
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
