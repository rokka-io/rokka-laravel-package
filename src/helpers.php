<?php

use Rokka\RokkaLaravel\RokkaLaravelServiceProvider;

if (!function_exists('rokka')) {
    /**
     * @param $hash
     * @return mixed
     */
    function rokka()
    {
        // TODO: Consider returning an instance of Rokka\Client\TemplateHelper instead
        // https://rokka.io/client-php-api/master/Rokka/Client/TemplateHelper.html

        return app(RokkaLaravelServiceProvider::ALIAS);
    }
}