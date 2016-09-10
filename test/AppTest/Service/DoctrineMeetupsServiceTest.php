<?php
declare(strict_types = 1);

namespace AppTest\Service;

use App\Entity\Meetup;
use App\Service\DoctrineMeetupsService;
use DateTimeImmutable;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @covers \App\Service\DoctrineMeetupsService
 */
class DoctrineMeetupsServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFindMeetupsAfterReturnsEmptyArrayWhenNoMeetupsFound()
    {
        $query = $this->createMock(AbstractQuery::class);
        $query->expects(self::once())->method('setParameters')->willReturnSelf();
        $query->expects(self::once())->method('getResult')->willReturn([]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('createQuery')->willReturn($query);

        $service = new DoctrineMeetupsService($entityManager);
        self::assertSame([], $service->findMeetupsAfter(new DateTimeImmutable()));
    }

    public function testFindMeetupsAfterReturnsMeetupsWhenFound()
    {
        $query = $this->createMock(AbstractQuery::class);
        $query->expects(self::once())->method('setParameters')->willReturnSelf();
        $query->expects(self::once())->method('getResult')->willReturn([
            $meetup = $this->createMock(Meetup::class),
        ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('createQuery')->willReturn($query);

        $service = new DoctrineMeetupsService($entityManager);
        self::assertSame([$meetup], $service->findMeetupsAfter(new DateTimeImmutable()));
    }

    public function testFindMeetupsBeforeReturnsEmptyArrayWhenNoMeetupsFound()
    {
        $query = $this->createMock(AbstractQuery::class);
        $query->expects(self::once())->method('setParameters')->willReturnSelf();
        $query->expects(self::once())->method('getResult')->willReturn([]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('createQuery')->willReturn($query);

        $service = new DoctrineMeetupsService($entityManager);
        self::assertSame([], $service->findMeetupsBefore(new DateTimeImmutable()));
    }

    public function testFindMeetupsBeforeReturnsMeetupsWhenFound()
    {
        $query = $this->createMock(AbstractQuery::class);
        $query->expects(self::once())->method('setParameters')->willReturnSelf();
        $query->expects(self::once())->method('getResult')->willReturn([
            $meetup = $this->createMock(Meetup::class),
        ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('createQuery')->willReturn($query);

        $service = new DoctrineMeetupsService($entityManager);
        self::assertSame([$meetup], $service->findMeetupsBefore(new DateTimeImmutable()));
    }
}
