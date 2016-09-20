<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\Location;

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

        self::assertSame('Venue Name', $location->getName());
        self::assertSame('Some Place, Some Town, County, A1 1AA', $location->getAddress());
        self::assertSame('http://test-uri', $location->getUrl());
    }
}
