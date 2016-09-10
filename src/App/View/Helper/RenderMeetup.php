<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Entity\Meetup as MeetupEntity;
use Zend\View\Helper\AbstractHelper;

final class RenderMeetup extends AbstractHelper
{
    public function full(MeetupEntity $meetup) : string
    {
        $humanReadableDate = $meetup->getFromDate()->format('jS F Y');
        $from_time = $meetup->getFromDate()->format('g:ia');
        if ($meetup->getToDate()) {
            $to_time = $meetup->getToDate()->format('g:ia');
        }
        $registration_url = $meetup->getEventbriteData()->getUrl();
        $location = $meetup->getLocation()->getName() . ', ' . $meetup->getLocation()->getAddress();
        $location_url = $meetup->getLocation()->getUrl();
        $topic = $meetup->getTopic();
        $talking_points = $meetup->getTalks();

        $talking_points_html = '';
        $talk_count = count($talking_points);
        foreach ($talking_points as $speaker => $point) {
            if (!is_numeric($speaker)) {
                $talking_points_html .= "            <li>{$point} &mdash; <em>(by {$speaker})</em></li>\n";
            } else {
                $talking_points_html .= "            <li>{$point}</li>\n";
            }
        }

        $str = "<h2>{$humanReadableDate}</h2>";

        $str .= "<ul class='meetup-details'>";

        if (isset($to_time)) {
            $str .= "<li><strong>Time:</strong> {$from_time} - {$to_time}</li>";
        } else {
            $str .= "<li><strong>Time:</strong> From {$from_time} (for ~2-3 hours)</li>";
        }

        if (isset($location_url)) {
            $str .= "<li><strong>Location:</strong> <a href=\"{$location_url}\">{$location}</a></li>";
        } else {
            $str .= "<li><strong>Location:</strong> {$location}</li>";
        }

        $str .= '<li><strong>Registration Required:</strong> ';
        $str .= "<a href=\"{$registration_url}\">{$registration_url}</a></li>";

        if (isset($topic)) {
            $str .= "<li><strong>Topic of the Month:</strong> {$topic}</li>";
        }

        $str .= '<li><strong>Talk' . ($talk_count > 1 ? 's' : '') . ':</strong>';
        $str .= "<ul class='talks'>\n{$talking_points_html}</ul></li>";

        $str .= '</ul>';

        $widget = $this->getView()->partial('layout::eventbrite-widget', [
            'eventId' => $meetup->getEventbriteData()->getEventbriteId(),
            'eventTitle' => 'PHP Hampshire ' . $meetup->getFromDate()->format('F Y') . ' Meetup',
        ]);

        if ($widget) {
            $str .= "<div class=\"padding\"></div>" . $widget;
        }

        return $str;
    }

    public function short(MeetupEntity $meetup) : string
    {
        $date = $meetup->getFromDate()->format('jS F Y');
        $talking_points = $meetup->getTalks();

        $talking_points_html = '';
        $talk_count = 0;
        foreach ($talking_points as $talk) {
            $s = $talk->getTitle() . ' &mdash; <em>(by ';

            if (null !== $talk->getSpeaker()->getTwitterHandle()) {
                $s .= '<strong><a href="https://twitter.com/' . $talk->getSpeaker()->getTwitterHandle() . '">'
                    . $talk->getSpeaker()->getFullName()
                    . '</a></strong>';
            } else {
                $s .= '<strong>' . $talk->getSpeaker()->getFullName(). '</strong>';
            }

            $s .= ')</em>';
            $talking_points_html .= '<li>' . $s . '</li>';
            $talk_count++;
        }

        $str = "<h2>{$date}</h2>";

        if ($talk_count) {
            $str .= "<ul class='meetup-details'>";
            $str .= '<li><strong>Talk'
                . ($talk_count > 1 ? 's' : '')
                . ":</strong><ul class='talks'>\n{$talking_points_html}</ul></li>";
            $str .= '</ul><br />';
        }

        return $str;
    }
}
