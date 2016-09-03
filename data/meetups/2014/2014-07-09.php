<?php

use App\Entity\Meetup;
use App\Entity\Talk;
use App\Entity\Schedule;

$etitle = 'PHP Hampshire - July 2014 Meetup';
$eid = '11915077317';
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
Performance issues can be caused by many things, from database interactions, web services, disk i/o and, less frequently, the code itself.<br /><br />
We would typically turn to a profiler like xhprof to diagnose these issues, but what if the bottleneck is PHP itself, where do you turn?<br /><br />
This talk will take that inspection a step further and look under the hood of PHP, at the C internals of how things tick.<br /><br />
This talk covers what every PHP developer should know about their tools — like what's really going on when you use double quotes vs single quotes.<br /><br />
If you’ve ever wanted to know exactly what your code is doing, and why ++\$i is faster than \$i++, this talk is for you.<br /><br />
END;

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2014-07-09 19:00'))
    ->setToDate(new DateTimeImmutable('2014-07-09 23:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NH&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NH,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis the Venue, Arundel Street, PO1 1NH')
    ->setTalkingPoints(array(
        new Talk('Davey Shafik', 'dshafik', 'PHP: Under the Hood', $abstract),
        '9pm Social @ Brewhouse Pompey (The White Swan)',
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
