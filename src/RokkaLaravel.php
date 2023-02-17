<?php

namespace Rokka\RokkaLaravel;

use InvalidArgumentException;
use Rokka\Client\Image;
use Rokka\Client\TemplateHelper;
use Rokka\Client\Factory as RokkaClientFactory;
use Rokka\Client\User;

/**
 * Class RokkaLaravel
 * @package Rokka\RokkaLaravel
 */
class RokkaLaravel
{
    protected string $organization;
    protected string $apiKey;
    protected array $requestOptions;
    protected ?string $publicRokkaDomain;
    protected TemplateHelper $templateHelper;

    /**
     * @param string $env
     */
    public function __construct(string $env = 'default')
    {
        $config = config('rokka', false);
        if (!$config) {
            throw new InvalidArgumentException(sprintf("Organization “%s” does not exist", $env));
        }
        $this->organization = $config['organisation_name'];
        $this->apiKey = $config['organisation_key'];
        $this->requestOptions = $config['request_options'];
        $this->publicRokkaDomain = $config['public_rokka_domain'];

        $this->templateHelper = new TemplateHelper(
            $this->organization,
            $this->apiKey,
            null,
            $this->getPublicRokkaDomain(),
            $this->requestOptions
        );

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
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $methodName, array $arguments): mixed
    {
        return call_user_func_array([$this->templateHelper, $methodName], $arguments);
    }

    /**
     * @return string
     */
    public function getOrganization(): string
    {
        return $this->organization;
    }

    /**
     * @param string|null $org
     * @return string|null
     */
    public function getPublicRokkaDomain(?string $org = null): ?string
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
     * @return Image
     */
    public function images(): Image
    {
        return RokkaClientFactory::getImageClient($this->organization, $this->apiKey, $this->requestOptions);
    }

    /**
     * Returns an instance of the Rokka user management client
     *
     * @see https://rokka.io/client-php-api/master/Rokka/Client/User.html
     * @return User
     */
    public function manage(): User
    {
        return RokkaClientFactory::getUserClient($this->organization, $this->apiKey, $this->requestOptions);
    }
}
