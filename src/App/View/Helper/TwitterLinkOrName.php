<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Entity\Speaker;
use Zend\View\Helper\AbstractHelper;

final class TwitterLinkOrName extends AbstractHelper
{
    public function __invoke(Speaker $speaker) : string
    {
        $escapeHtmlAttr = $this->getView()->plugin('escapeHtmlAttr');
        $escapeHtml = $this->getView()->plugin('escapeHtml');

        $pre = '';
        $post = '';

        if (null !== $speaker->getTwitterHandle()) {
            $pre = '<a href="https://twitter.com/' . $escapeHtmlAttr($speaker->getTwitterHandle()) . '">';
            $post = '</a>';
        }

        return $pre . $escapeHtml($speaker->getFullName()) . $post;
    }
}
