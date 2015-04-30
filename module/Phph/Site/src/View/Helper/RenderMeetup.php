<?php

namespace Phph\Site\View\Helper;

use Phph\Site\Model\TalkEntity;
use Zend\View\Helper\AbstractHelper;
use Phph\Site\Model\MeetupEntity;

class RenderMeetup extends AbstractHelper
{
    public function full(MeetupEntity $meetup)
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
        $talk_count = count($talking_points);
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

        $str .= "<li><strong>Talk" . ($talk_count > 1 ? 's' : '') . ":</strong><ul class='talks'>\n{$talking_points_html}</ul></li>";

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

    public function short(MeetupEntity $meetup)
    {
        $date = $meetup->getFromDate()->format('jS F Y');
        $talking_points = $meetup->getTalkingPoints();

        $talking_points_html = '';
        $talk_count = 0;
        foreach ($talking_points as $point) {
            if ($point instanceof TalkEntity) {
                $s = $point->getTalkName() . ' &mdash; <em>(by ';

                if ($point->getSpeakerTwitter() != '') {
                    $s .= '<strong><a href="https://twitter.com/' . $point->getSpeakerTwitter() . '">' . $point->getSpeakerName() . '</a></strong>';
                } else {
                    $s .= '<strong>' . $point->getSpeakerName() . '</strong>';
                }

                $s .= ')</em>';
                $talking_points_html .= $s;
                $talk_count++;
            }
        }

        $str = "<h2>{$date}</h2>";
        $str .= "<ul class='meetup-details'>";
        $str .= "<li><strong>Talk" . ($talk_count > 1 ? 's' : '') . ":</strong><ul class='talks'>\n{$talking_points_html}</ul></li>";
        $str .= "</ul><br />";

        return $str;
    }
}
