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
            'FriendlyTerry1970',
            'Terry is a brilliant speaker and is brilliant at PHP.',
            'filename123.jpg'
        );

        self::assertTrue(Uuid::isValid($speaker->getId()));
        self::assertSame('Friendly Terry', $speaker->getFullName());
        self::assertSame('FriendlyTerry1970', $speaker->getTwitterHandle());
        self::assertSame('Terry is a brilliant speaker and is brilliant at PHP.', $speaker->getBiography());
        self::assertSame('filename123.jpg', $speaker->getImageFilename());
    }

    public function testUpdateFromData()
    {
        $speaker = Speaker::fromNameAndTwitter(
            'Friendly Terry',
            'FriendlyTerry1970',
            'Terry is a brilliant speaker and is brilliant at PHP.',
            'filename123.jpg'
        );

        $speaker->updateFromData(
            'Angry Terry',
            'AngryTerry1971',
            'Terry is a terrible speaker and is awful at PHP.',
            'filename321.jpg'
        );

        self::assertSame('Angry Terry', $speaker->getFullName());
        self::assertSame('AngryTerry1971', $speaker->getTwitterHandle());
        self::assertSame('Terry is a terrible speaker and is awful at PHP.', $speaker->getBiography());
        self::assertSame('filename321.jpg', $speaker->getImageFilename());
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

    public function testBioChangesToNullWhenEmptyStringProvided()
    {
        $speaker = Speaker::fromNameAndTwitter(
            'Sally Smith',
            null,
            '',
            null
        );

        self::assertNull($speaker->getBiography());

        $speaker->updateFromData('Sally Smith', null, '', null);

        self::assertNull($speaker->getBiography());
    }

    public function testImageFilenameChangesToNullWhenEmptyStringProvided()
    {
        $speaker = Speaker::fromNameAndTwitter(
            'Sally Smith',
            null,
            null,
            ''
        );

        self::assertNull($speaker->getImageFilename());

        $speaker->updateFromData('Sally Smith', null, null, '');

        self::assertNull($speaker->getImageFilename());
    }
}
