<?php
declare(strict_types = 1);

namespace AppTest\Service\Video;

use App\Entity\Video;
use App\Service\Video\DoctrineGetAllVideos;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @covers \App\Service\Video\DoctrineGetAllVideos
 */
class DoctrineGetAllVideosTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeCallsFindAllOnObjectRepository()
    {
        $videos = [
            $this->createMock(Video::class),
            $this->createMock(Video::class),
        ];

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())->method('findAll')->with()->willReturn($videos);

        self::assertSame($videos, (new DoctrineGetAllVideos($objectRepository))->__invoke());
    }
}
