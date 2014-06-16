<?php

namespace Phph\Members\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\Gravatar;

class RenderMember extends AbstractHelper
{
    public function __invoke(array $member)
    {
        $output = '';

        $output .= '<div class="avatar" >' . $this->view->Gravatar($member['email']) . '</div>';
        $output .= '<h2>'. $this->view->escapeHtml($member['name']) . '</h2>';
        $output .= '<div class="twitter" >' . $this->view->escapeHtml($member['twitter']) . '</div>';
        $output .= '<div class="website" >' . $this->view->escapeHtml($member['website']) . '</div>';

        return $output;
    }
}
