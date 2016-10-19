<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\Speaker;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Entity\Speaker
 */
class SpeakerTest extends \PHPUnit_Framework_TestCase
{
    public function testFromNameAndTwitter()
    {
        $speaker = Speaker::fromNameAndTwitter(
            'Friendly Terry',
            'FriendlyTerry1970'
        );

        self::assertTrue(Uuid::isValid($speaker->getId()));
        self::assertSame('Friendly Terry', $speaker->getFullName());
        self::assertSame('FriendlyTerry1970', $speaker->getTwitterHandle());
    }

    public function testUpdateFromData()
    {
        $speaker = Speaker::fromNameAndTwitter(
            'Friendly Terry',
            'FriendlyTerry1970'
        );

        $speaker->updateFromData(
            'Angry Terry',
            'AngryTerry1971'
        );

        self::assertSame('Angry Terry', $speaker->getFullName());
        self::assertSame('AngryTerry1971', $speaker->getTwitterHandle());
    }

    public function testTwitterHandleChangesToNullWhenEmptyStringProvided()
    {
        $speaker = Speaker::fromNameAndTwitter(
            'Sally Smith',
            ''
        );

        self::assertNull($speaker->getTwitterHandle());

        $speaker->updateFromData('Sally Smith', '');

        self::assertNull($speaker->getTwitterHandle());
    }
}
