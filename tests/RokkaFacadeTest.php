<?php

namespace Rokka\RokkaLaravel\Tests;

use Rokka\Client\Image;
use Rokka\Client\User;
use Rokka\RokkaLaravel\Facades\Rokka;

class RokkaFacadeTest extends TestCase
{
    public function testOrganization()
    {
        $this->assertEquals(config('rokka.organisation_name'), Rokka::getOrganization());
    }

    public function testPublicDomain()
    {
        $this->assertEquals(config('rokka.public_rokka_domain'), Rokka::getPublicRokkaDomain());
    }

    public function testImagesClient()
    {
        $this->assertInstanceOf(Image::class, Rokka::images());
    }

    public function testUserManagementClient()
    {
        $this->assertInstanceOf(User::class, Rokka::manage());
    }
}