<?php
declare(strict_types = 1);

namespace AppTest\Service\Video;

use App\Entity\Talk;
use App\Service\Talk\DoctrineFindTalksWithVideo;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @covers \App\Service\Talk\DoctrineFindTalksWithVideo
 */
class DoctrineFindTalksWithVideoTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeCallsFindAllOnObjectRepository()
    {
        $videos = [
            $this->createMock(Talk::class),
            $this->createMock(Talk::class),
        ];

        $queryObjectMock = $this->createMock(AbstractQuery::class);
        $queryObjectMock->expects(self::once())->method('execute')->willReturn($videos);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('createQuery')
            ->willReturnCallback(function ($dqlQuery) use ($queryObjectMock) {
                self::assertContains('t.youTubeId IS NOT NULL', $dqlQuery);
                self::assertContains('ORDER BY t.time DESC', $dqlQuery);
                return $queryObjectMock;
            }
        );

        self::assertSame($videos, (new DoctrineFindTalksWithVideo($entityManager))->__invoke());
    }
}
