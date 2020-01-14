<?php

use Rokka\RokkaLaravel\RokkaLaravelServiceProvider;

if (!function_exists('rokka')) {
    function rokka()
    {
        return app(RokkaLaravelServiceProvider::ALIAS);
    }
}
