<?php

namespace Phph\Site\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Phph\Site\Model\MeetupEntity;

class RenderMeetup extends AbstractHelper
{
    public function __invoke(MeetupEntity $meetup)
    {
        $date = $meetup->getDate()->format('jS F Y');
        $time = $meetup->getDate()->format('ga');
        $location = $meetup->getLocation();
        $topic = $meetup->getTopic();
        $talking_points = $meetup->getTalkingPoints();

        $talking_points_html = '';
        foreach ($talking_points as $point) {
            $talking_points_html .= "			<li>{$point}</li>\n";
        }

        $str = <<<DOC
<h3>{$date}</h3>
<ul>
    <li><strong>Time:</strong> From {$time} (for ~2-3 hours)</li>
    <li><strong>Location:</strong> {$location}</li>
    <li><strong>Topic of the Month:</strong> {$topic}</li>
    <li><strong>Talking points</strong>
        <ul>\n{$talking_points_html}</ul>
    </li>
</ul>
DOC;

        return $str;
    }
}
