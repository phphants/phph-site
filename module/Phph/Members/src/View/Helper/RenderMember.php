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
        $output .= '<div class="member-text">';
        $output .= '<h2>'. $this->view->escapeHtml($member['name']) . '</h2>';
        $output .= '<div class="twitter" ><a href="https://twitter.com/' . $this->view->escapeHtml($member['twitter']) . '" >' . $this->view->escapeHtml($member['twitter']) . '</a></div>';
        $output .= '<div class="website" ><a href="' . $this->view->escapeHtml($member['website']) .'" >' . $this->view->escapeHtml($member['website']) . '</a></div>';
        $output .= '</div>';

        return $output;
    }
}
