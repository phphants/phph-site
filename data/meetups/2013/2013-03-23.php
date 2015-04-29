<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;

$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="http://www.eventbrite.co.uk/tickets-external?eid=5224635024&ref=etckt&v=2" frameborder="0" height="214" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk/event/5224635024?ref=etckt">PHP Hampshire - March Meetup</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setFromDate(new DateTime('2013-03-23 15:00'))
    ->setToDate(new DateTime('2013-03-23 18:00'))
    ->setRegistrationUrl("http://www.eventbrite.co.uk/event/5224635024")
    ->setLocationUrl("http://goo.gl/maps/WzD3p")
    ->setLocation('Port 57, Portsmouth')
    ->setTalkingPoints(array(
        new TalkEntity('Lee Boynton', 'leeboynton', 'Integrating Node.js With PHP'),
        new TalkEntity('Phil Bennett', 'phil_bennett', 'Creating a native iOS and Android App in 20 mins using HTML5, Yii and PhoneGap'),
        new TalkEntity('Eddie Abou-Jaoude', 'eddiejaoude', 'Zend Framework, The "M" in MVC'),
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
