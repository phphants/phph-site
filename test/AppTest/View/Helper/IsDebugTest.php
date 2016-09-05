<?php
declare(strict_types = 1);

namespace AppTest\View\Helper;

use App\View\Helper\IsDebug;

/**
 * @covers \App\View\Helper\IsDebug
 */
class IsDebugTest extends \PHPUnit_Framework_TestCase
{
    public function testIsDebugReturnsDebugSetting()
    {
        self::assertTrue((new IsDebug(true))->__invoke());
        self::assertFalse((new IsDebug(false))->__invoke());
    }
}
