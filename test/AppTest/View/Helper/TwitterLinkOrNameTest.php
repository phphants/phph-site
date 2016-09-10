<?php
declare(strict_types = 1);

namespace AppTest\View\Helper;

use App\Entity\Speaker;
use App\View\Helper\TwitterLinkOrName;
use Zend\View\Renderer\PhpRenderer;

/**
 * @covers \App\View\Helper\TwitterLinkOrName
 */
class TwitterLinkOrNameTest extends \PHPUnit_Framework_TestCase
{
    public function testSpeakerWithoutTwitterReturnsName()
    {
        $view = $this->createMock(PhpRenderer::class);
        $view->expects(self::atLeastOnce())->method('plugin')->willReturn(function ($input) {
            return $input;
        });

        $helper = new TwitterLinkOrName();
        $helper->setView($view);

        self::assertSame(
            'Jane Doe',
            $helper(Speaker::fromNameAndTwitter('Jane Doe'))
        );
    }

    public function testSpeakerWithoutTwitterReturnsTwitterLink()
    {
        $view = $this->createMock(PhpRenderer::class);
        $view->expects(self::atLeastOnce())->method('plugin')->willReturn(function ($input) {
            return $input;
        });

        $helper = new TwitterLinkOrName();
        $helper->setView($view);

        self::assertSame(
            '<a href="https://twitter.com/janedoe">Jane Doe</a>',
            $helper(Speaker::fromNameAndTwitter('Jane Doe', 'janedoe'))
        );
    }
}
