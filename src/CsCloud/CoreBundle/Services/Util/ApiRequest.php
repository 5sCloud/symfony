<?php

namespace CsCloud\CoreBundle\Services\Util;

use CsCloud\CoreBundle\Util\Url;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class ApiRequest
{
    /**
     * The current request url
     * @var Url
     */
    protected $url = null;

    /**
     * HTTP method
     * @var string
     */
    protected $method = "GET";

    /**
     * POST parameters
     * @var ParameterBag
     */
    protected $parameters;

    /**
     * Cookies
     * @var ParameterBag
     */
    protected $cookies;

    /**
     * Files
     * @var ParameterBag
     */
    protected $files;

    /**
     * Server
     * @var ParameterBag
     */
    protected $server;

    /**
     * Raw content request
     * @var string
     */
    protected $content = null;

    /**
     * Indicates weather the request is exception safe or not
     * @var bool
     */
    protected $safe = false;

    /**
     * The error codes listed in this array will be NOT thrown an exception
     * @var array
     */
    protected $safe_codes = null;

    /**
     * Request locale
     * @var string
     */
    protected $locale = 'it';

    /**
     * Create a new ApiRequest object
     *
     * @param string|Url $uri The resource path
     * @param array $query Additional query (GET) parameters
     */
    public function __construct($uri, $query = array())
    {
        if (!$uri instanceof Url) {
            $uri = new Url($uri);
        }

        $uri->setQueryParameters($query);
        $this->url = $uri;

        $this->parameters = new ParameterBag;
        $this->cookies = new ParameterBag;
        $this->files = new ParameterBag;
        $this->server = new ParameterBag;
    }

    /**
     * Get the request URL
     * @return string
     */
    public function getUrl()
    {
        return $this->url->toString();
    }

    /**
     * Get request method
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Change request method
     * @param string $method
     * @return ApiRequest
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Return the parameters (POST) bag
     * @return ParameterBag
     */
    public function getParameterBag()
    {
        return $this->parameters;
    }

    /**
     * Set parameters (POST)
     * @param array $params
     * @return ApiRequest
     */
    public function setParameters(array $params)
    {
        $this->parameters->replace($params);
        return $this;
    }

    /**
     * Add a parameter to the parameter bag (POST)
     * @param mixed $key
     * @param mixed $value
     * @return ApiRequest
     */
    public function addParameter($key, $value)
    {
        $this->parameters->add(array($key => $value));
        return $this;
    }

    /**
     * Return the cookies bag
     * @return ParameterBag
     */
    public function getCookiesBag()
    {
        return $this->cookies;
    }

    /**
     * Return the files bag
     * @return ParameterBag
     */
    public function getFilesBag()
    {
        return $this->files;
    }

    /**
     * Return the server variables bag
     * @return ParameterBag
     */
    public function getServerBag()
    {
        return $this->server;
    }

    /**
     * Set request raw content
     * @param string $content
     * @return ApiRequest
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get request raw content
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets if the request should throw an exeception in case of client error
     * @param boolean $safe
     * @return ApiRequest
     */
    public function setSafe($safe)
    {
        $this->safe = (bool)$safe;
        return $this;
    }

    /**
     * Return if the request should throw an exception in case of client error
     * @return boolean
     */
    public function isSafe()
    {
        return $this->safe;
    }

    /**
     * Sets a list of error codes weather the request should not thrown an exception
     * @param array $codes
     * @return ApiRequest
     */
    public function setSafeCodes(array $codes = null)
    {
        $this->safe_codes = $codes;
        return $this;
    }

    /**
     * Check if the error code is safe
     * @param int $code
     * @return boolean
     */
    public function isSafeFor($code)
    {
        return ($this->safe_codes !== null && in_array($code, $this->safe_codes));
    }

    /**
     * Set the request locale
     * @param string $locale
     * @return ApiRequest
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Get request locale
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
