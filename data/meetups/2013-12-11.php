<?php

use Phph\Site\Model\MeetupEntity;
use Phph\Site\Model\TalkEntity;
use Phph\Site\Model\ScheduleEntity;

$etitle = 'PHP Hampshire - December Meetup';
$eid = '8872569093';
$eventbriteWidget = '<div style="width:100%; text-align:left; padding-top: 20px" >';
$eventbriteWidget .= '<iframe  src="http://www.eventbrite.co.uk/tickets-external?eid=' . $eid . '&ref=etckt&v=2" frameborder="0" height="214" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>';
$eventbriteWidget .= '<div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" >';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk/r/etckt">Event Registration Online</a>';
$eventbriteWidget .= '<span style="color:#888;"> for </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk/event/' . $eid . '?ref=etckt">' . $etitle . '</a>';
$eventbriteWidget .= '<span style="color:#888;"> powered by </span>';
$eventbriteWidget .= '<a style="color:#888; text-decoration:none;" target="_blank" href="http://www.eventbrite.co.uk?ref=etckt">Eventbrite</a>';
$eventbriteWidget .= '</div></div>';

$meetup = new MeetupEntity();

$meetup->setId(0)
    ->setFromDate(new DateTime('2013-12-11 19:00'))
    ->setToDate(new DateTime('2013-12-11 23:00'))
    ->setRegistrationUrl("http://www.eventbrite.co.uk/event/{$eid}")
    ->setLocationUrl("https://www.google.co.uk/maps?q=Oasis+Venue,+Arundel+Street,+PO1+1NH&hl=en&ll=50.799642,-1.086724&spn=0.011772,0.031629&sll=50.799734,-1.086874&sspn=0.011772,0.031629&hq=Oasis+Venue,&hnear=Arundel+St,+PO1+1NH,+United+Kingdom&t=m&z=16")
    ->setLocation('Oasis Conference Centre, Arundel Street, PO1 1NH')
    ->setTalkingPoints(array(
        new TalkEntity('Phil Bennett', 'phil_bennett', 'How to develop your development of being a developer without doing any developing', 'A light hearted look at being less shit, covering the periphery skills required including communication, delivery and not being a berk.'),
        new TalkEntity('Gareth Evans', 'garoevans', 'PHP and Enums', 'This talk should begin with a very general introduction to Enums. What is an
Enum and what is it for? Then, the direction should turn towards PHP, how does
this work in PHP, where do I need it in PHP what are the benefits of using it.

I then want to cover how you can use Enums, using SplEnum and talk very briefly
about SplType.

Finally, I\'d like to plug my php-enum library by stepping into a few things that
it does to make your life easier in comparison to SplEnum.'),
        'Pink elePHPant raffle:  Raffle tickets are £1 per entry, or £3 for 5 entries (a strip). Raffle tickets will be available at the event only.',
        'Loads of prize giveaways from Zend, GitHub, JetBrains PhpStorm, O\'Reilly, SpectrumIT, FTPloy',
        'Also some extra special Christmas treats!',
        '9pm Social @ Brewhouse Pompey (The White Swan)',
    ))
    ->setWidget($eventbriteWidget);

return $meetup;
