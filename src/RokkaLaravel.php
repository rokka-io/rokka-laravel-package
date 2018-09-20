<?php

namespace Rokka\RokkaLaravel;

use InvalidArgumentException;
use Rokka\Client\TemplateHelper;
use Rokka\Client\Factory as RokkaClientFactory;

/**
 * Class RokkaLaravel
 * @package Rokka\RokkaLaravel
 */
class RokkaLaravel
{
    /**
     * @var string
     */
    protected $organization;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $requestOptions;

    /**
     * RokkaLaravel constructor.
     * @param string $env
     */
    public function __construct($env = 'default')
    {
        $config = config('rokka.organizations.' . $env, false);
        if (!$config) {
            throw new InvalidArgumentException(sprintf("Organization “%s” does not exist", $env));
        }
        $this->organization = $config['name'];
        $this->apiKey = $config['key'];
        $this->requestOptions = $config['requestOptions'];
    }

    /**
     * Forward all other method calls to an instance of Rokka\Client\TemplateHelper
     *
     * @see https://rokka.io/client-php-api/master/Rokka/Client/TemplateHelper.html
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
    public function __call($methodName, $arguments)
    {
        $rokka = new TemplateHelper($this->organization, $this->apiKey, $this->requestOptions);
        return call_user_func_array([$rokka, $methodName], $arguments);
    }

    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Returns an instance of the Rokka image
     *
     * @see https://rokka.io/client-php-api/master/Rokka/Client/Image.html
     * @return \Rokka\Client\Image
     */
    public function images()
    {
        return $this->getClient('image');
    }

    /**
     * Returns an instance of the Rokka user management client
     *
     * @see https://rokka.io/client-php-api/master/Rokka/Client/User.html
     * @return \Rokka\Client\Image|\Rokka\Client\User
     */
    public function manage()
    {
        return $this->getClient('user');
    }

    /**
     * Return an instance of a Rokka Image or User client
     *
     * @param string $client
     * @return \Rokka\Client\Image|\Rokka\Client\User
     */
    public function getClient($client = 'image')
    {
        if ($client === 'user') {
            return RokkaClientFactory::getUserClient($this->requestOptions);
        }
        return RokkaClientFactory::getImageClient($this->organization, $this->apiKey, $this->requestOptions);
    }
}
