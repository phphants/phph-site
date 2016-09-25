<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\Talk;
use App\Entity\Video;

/**
 * @covers \App\Entity\Video
 */
class VideoTest extends \PHPUnit_Framework_TestCase
{
    public function testFromTalk()
    {
        $talk = $this->createMock(Talk::class);

        $video = Video::fromTalk($talk, 'Ns9g_gcyqG4');

        self::assertInstanceOf(Video::class, $video);
        self::assertSame($talk, $video->getTalk());
        self::assertSame('Ns9g_gcyqG4', $video->getYoutubeId());
    }
}
