<?php

namespace Phph\Site\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Phph\Site\Model\MeetupEntity;

class RenderMeetup extends AbstractHelper
{
    public function __invoke(MeetupEntity $meetup)
    {
        $date = $meetup->getFromDate()->format('jS F Y');
        $from_time = $meetup->getFromDate()->format('g:ia');
        if ($meetup->getToDate()) {
            $to_time = $meetup->getToDate()->format('g:ia');
        }
        $registration_url = $meetup->getRegistrationUrl();
        $location = $meetup->getLocation();
        $location_url = $meetup->getLocationUrl();
        $topic = $meetup->getTopic();
        $talking_points = $meetup->getTalkingPoints();

        $talking_points_html = '';
        foreach ($talking_points as $speaker => $point) {
            if (!is_numeric($speaker)) {
                $talking_points_html .= "			<li>{$point} &mdash; <em>(by {$speaker})</em></li>\n";
            } else {
                $talking_points_html .= "			<li>{$point}</li>\n";
            }
        }

        $str = "<h2>{$date}</h2>";

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

        $str .= "<li><strong>Registration Required:</strong> <a href=\"{$registration_url}\">{$registration_url}</a></li>";

        if (isset($topic)) {
            $str .= "<li><strong>Topic of the Month:</strong> {$topic}</li>";
        }

        $str .= "<li><strong>Talks:</strong><ul class='talks'>\n{$talking_points_html}</ul></li>";

        if (count($meetup->getSchedule()) > 0) {
            $str .= "<li><strong>Schedule:</strong><ul>\n";

            foreach ($meetup->getSchedule() as $item) {
                $str .= "			<li>{$item}</li>\n";
            }

            $str .= "</ul></li>";
        }

        $str .= "</ul>";

        $widget = $meetup->getWidget();

        if ($widget)
        {
            $str .= "<div class=\"padding\"></div>" . $widget;
        }

        return $str;
    }
}
