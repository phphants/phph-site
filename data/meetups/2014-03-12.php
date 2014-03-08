<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - March 2014 Meetup';
$eid = '9904061314';
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
We've got something a little different this time around! We've got a Zend elePHPant hunt. <em>You'll need to bring a laptop and have downloaded the Zend Server installer beforehand.</em><br /><br />
<strong>What is an elePHPant Hunt?</strong><br />
It's your opportunity to get your hands on "Chilli" the Red elePHPant with the help of Zend. You'll need to bring a laptop and have downloaded a copy of Zend Server to take part. You'll install Zend Server, and a representative from Zend will ask you a few questions about Zend Server. When you have completed the challenge, you will be entered in the draw to win a Red ElePHPant! Simple as that!
END;

$meetup->setId(0)
    ->setFromDate(new DateTime('2014-03-12 19:00'))
    ->setToDate(new DateTime('2014-03-12 23:00'))
    ->setRegistrationUrl("http://ele.phphants.co.uk/")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NH&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NH,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis Conference Centre, Arundel Street, PO1 1NH')
    ->setTalkingPoints(array(
        new TalkEntity('Zend', 'zend', 'The Great PHP Hampshire Zend elePHPant Hunt', $abstract),
        new TalkEntity('Kimberley Ford', 'luco_el_loco', 'Kim\'s Car: An Introduction to Object Oriented Programming in PHP'),
        new TalkEntity('Rebecca Short', 'BeckiShort', 'Coding with SEO in mind'),
        '9pm Social @ Brewhouse Pompey (The White Swan)',
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
