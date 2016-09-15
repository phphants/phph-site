<?php

use App\Entity\Meetup;
use App\Entity\Talk;

$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="https://www.eventbrite.co.uk/tickets-external?eid=5224635024&ref=etckt&v=2" frameborder="0" height="214" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk/event/5224635024?ref=etckt">PHP Hampshire - March Meetup</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="https://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new Meetup();

$meetup->setId(0)
    ->setFromDate(new DateTimeImmutable('2013-03-23 15:00'))
    ->setToDate(new DateTimeImmutable('2013-03-23 18:00'))
    ->setRegistrationUrl("https://www.eventbrite.co.uk/event/5224635024")
    ->setLocationUrl("http://goo.gl/maps/WzD3p")
    ->setLocation('Port 57, Portsmouth')
    ->setTalkingPoints(array(
        new Talk('Lee Boynton', 'leeboynton', 'Integrating Node.js With PHP'),
        new Talk('Phil Bennett', 'phil_bennett', 'Creating a native iOS and Android App in 20 mins using HTML5, Yii and PhoneGap'),
        new Talk('Eddie Abou-Jaoude', 'eddiejaoude', 'Zend Framework, The "M" in MVC'),
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
