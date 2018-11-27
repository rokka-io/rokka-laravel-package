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
     * @var string
     */
    protected $publicRokkaDomain;

    /**
     * RokkaLaravel constructor.
     * @param string $env
     */
    public function __construct($env = 'default')
    {
        $config = config('rokka', false);
        if (!$config) {
            throw new InvalidArgumentException(sprintf("Organization “%s” does not exist", $env));
        }
        $this->organization = $config['organisation_name'];
        $this->apiKey = $config['organisation_key'];
        $this->requestOptions = $config['request_options'];
        $this->publicRokkaDomain = $config['public_rokka_domain'];

        if (!$this->organization) {
            throw new InvalidArgumentException("config rokka.organisation_name is invalid");
        }
        if (!$this->apiKey) {
            throw new InvalidArgumentException("config rokka.organisation_key is invalid");
        }
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
     * @param null $org
     * @return null|string
     */
    public function getPublicRokkaDomain($org = null)
    {
        if (!$org) {
            return $this->publicRokkaDomain;
        }

        return $org === $this->getOrganization() ? $this->publicRokkaDomain : null;
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
            return RokkaClientFactory::getUserClient($this->organization, $this->apiKey, $this->requestOptions);
        }
        return RokkaClientFactory::getImageClient($this->organization, $this->apiKey, $this->requestOptions);
    }
}
