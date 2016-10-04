<?php
declare(strict_types = 1);

namespace AppTest\Service\Speaker;

use App\Entity\Speaker;
use App\Service\Speaker\DoctrineGetAllSpeakers;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @covers \App\Service\Speaker\DoctrineGetAllSpeakers
 */
class DoctrineGetAllSpeakersTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeCallsFindAllOnObjectRepository()
    {
        $speakers = [
            Speaker::fromNameAndTwitter('Sally Smith', 'SallySmith'),
            Speaker::fromNameAndTwitter('Terry Smith', 'TerrySmith'),
        ];

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findBy')
            ->with([], ['name' => 'ASC'])
            ->willReturn($speakers);

        self::assertSame($speakers, (new DoctrineGetAllSpeakers($objectRepository))->__invoke());
    }
}
