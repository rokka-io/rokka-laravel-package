<?php

namespace Rokka\RokkaLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use Rokka\Client\Image;
use Rokka\Client\User;
use Rokka\RokkaLaravel\RokkaLaravelServiceProvider;

/**
 * @see https://rokka.io/client-php-api/master/Rokka/Client/TemplateHelper.html
 *
 * @method static string getOrganization() Get the organization name.
 * @method static string getPublicRokkaDomain(?string $org = null) Get the public Rokka domain.
 * @method static Image images() Returns an instance of the Rokka image client
 * @method static User manage() Returns an instance of the Rokka user management client.
 */
class Rokka extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return RokkaLaravelServiceProvider::ALIAS;
    }
}
