<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;

$etitle = 'PHP Hampshire - August Meetup';
$eid = '6901521637';
$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="https://www.eventbrite.co.uk/tickets-external?eid=' . $eid . '&ref=etckt&v=2" frameborder="0" height="214" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/event/' . $eid . '?ref=etckt">' . $etitle . '</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setFromDate(new DateTime('2013-08-14 18:00'))
    ->setToDate(new DateTime('2013-08-14 21:30'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NH&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NH,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis Conference Centre, Arundel Street, PO1 1NH')
    ->setTalkingPoints(
        array(
            '"Better Testing Forum"
<p>A group discussion on various testing methodologies and how to implement them in your applications.
We will be taking a look at PHPUnit, Selenium2 and getting Jenkins to run automated tests. We will be discussing unit testing, how we use mocks and why you might not want to, integration testing and what other techniques people use.<br> 
Following on from last month\'s meetup, we will be discussing our first impressions of using storyplayer.</p>
<p>If you are new to automated testing, or have no idea where to start, this is a great way to get up to speed and get hands-on help.</p>
<p>You may want to bring a laptop, although all resources will be posted on <a href="https://github.com/phphants" >Github</a> after the event.</p>
'
        )
    )
    ->setWidget($eventbriteWidget);

return $meetup;
