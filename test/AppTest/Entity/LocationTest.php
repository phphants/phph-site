<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\Location;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Entity\Location
 */
class LocationTest extends \PHPUnit_Framework_TestCase
{
    public function testFromNameAddressAndUrl()
    {
        $location = Location::fromNameAddressAndUrl(
            'Venue Name',
            'Some Place, Some Town, County, A1 1AA',
            'http://test-uri'
        );

        self::assertTrue(Uuid::isValid($location->getId()));
        self::assertSame('Venue Name', $location->getName());
        self::assertSame('Some Place, Some Town, County, A1 1AA', $location->getAddress());
        self::assertSame('http://test-uri', $location->getUrl());
    }

    public function testUpdateFromData()
    {
        $location = Location::fromNameAddressAndUrl(
            'Venue Name',
            'Some Place, Some Town, County, A1 1AA',
            'http://test-uri'
        );

        $location->updateFromData(
            'Venue 2',
            'Address 2',
            'https://test-uri-2'
        );

        self::assertSame('Venue 2', $location->getName());
        self::assertSame('Address 2', $location->getAddress());
        self::assertSame('https://test-uri-2', $location->getUrl());
    }
}
