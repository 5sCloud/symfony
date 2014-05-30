<?php

namespace CsCloud\CoreBundle\Util;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Description of Url
 *
 * @author alekitto
 */
class Url
{
    public $originalUrl;

    public $scheme = 'http';
    public $host = null;
    public $port = 80;
    public $username = null;
    public $password = null;
    public $path = null;
    public $queryString = null;
    public $fragment = null;

    /**
     * @var ParameterBag 
     */
    protected $query = null;

    /**
     * Constructor
     * @param string $url MUST be a valid url
     */
    public function __construct($url)
    {
        $this->originalUrl = $url;

        if (null === $url || empty($url)) {
            throw new \LogicException("Empty url has been passed. Cannot continue");
        }

        if (($parsed = parse_url($url)) === false) {
            throw new \LogicException("Url must be valid. Maybe a validator should be called first?");
        }

        if (isset($parsed['scheme'])) {
            $this->scheme = $parsed['scheme'];
        }
        if (isset($parsed['host'])) {
            $this->host = $parsed['host'];
        }
        $this->processPort(isset($parsed['port']) ? $parsed['port'] : null);
        if (isset($parsed['user'])) {
            $this->username = $parsed['user'];
        }
        if (isset($parsed['pass'])) {
            $this->password = $parsed['pass'];
        }
        if (isset($parsed['path'])) {
            $this->path = $parsed['path'];
        }

        if (isset($parsed['query'])) {
            $this->setQuery($parsed['query']);
        } else {
            $this->query = new ParameterBag;
        }

        if (isset($parsed['fragment'])) {
            $this->fragment = $parsed['fragment'];
        }
    }

    /**
     * Set the port if specified, otherwise try to guess the default port for
     * the scheme.
     * @param integer $parsed
     */
    protected function processPort($parsed = null)
    {
        if ($parsed !== null) {
            $this->port = $parsed;
            return;
        }

        switch ($this->scheme) {
            case 'http':
                $this->port = 80;
                break;
            case 'https':
                $this->port = 443;
                break;
            case 'ftp':
                $this->port = 21;
                break;
            case 'ssh':
            case 'scp':
            case 'sftp':
                $this->port = 22;
                break;
            default:
                $this->port = null;
                break;
        }
    }

    /**
     * Parse the query string, build a query parameter bag and a query string
     * @param string $query
     */
    public function setQuery($query)
    {
        $params = array();
        parse_str($query, $params);

        $this->query = new ParameterBag($params);
        $this->generateQueryString();
    }

    /**
     * Generates a querystring from the query parameters
     */
    protected function generateQueryString()
    {
        $params = $this->query->all();
        ksort($params);

        $this->queryString = http_build_query($params, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * Get all the query parameters
     */
    public function getQueryParameters()
    {
        return $this->query->all();
    }

    /**
     * Set query parameters
     * @param array $paramters
     * @return Url
     */
    public function setQueryParameters(array $paramters)
    {
        $this->query->replace($paramters);
        $this->generateQueryString();
        return $this;
    }

    /**
     * Add a query parameter
     * @param string $key
     * @param mixed $value
     * @return Url
     */
    public function setQueryParameter($key, $value)
    {
        $this->query->set($key, $value);
        $this->generateQueryString();
        return $this;
    }

    /**
     * Get a parameter from query parameter bag
     * @param string $key
     * @return mixed|null
     */
    public function getQueryParameter($key)
    {
        return $this->query->get($key);
    }

    /**
     * Get the url scheme
     * @return string|null
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Get the url port
     * @return string|null
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Should this url explicitly include the port number?
     * @return boolean
     */
    protected function shouldIncludePort()
    {
        switch ($this->scheme) {
            case 'http':
                return $this->port !== 80;
            case 'https':
                return $this->port !== 443;
            case 'ftp':
                return $this->port !== 21;
            case 'ssh':
            case 'scp':
            case 'sftp':
                return $this->port !== 22;
        }
        return true;
    }

    /**
     * Get scheme, host and eventually username, password and port
     * @return string|null
     */
    public function getSchemeAndHost()
    {
        if (!$this->host) {
            return null;
        }

        $url = $this->scheme;
        $url .= $url ? '://' : '';

        if ($this->username) {
            $url .= $this->username;
            if ($this->password) {
                $url .= ':' . $this->password;
            }
            $url .= '@';
        }
        $url .= $this->host;

        if ($this->shouldIncludePort()) {
            $url .= ':' . $this->port;
        }
        return $url;
    }

    /**
     * Get the complete url
     * @return string
     */
    public function toString()
    {
        $this->generateQueryString();
        return $this->getSchemeAndHost() .
                $this->path .
                ($this->queryString ? '?' . $this->queryString : '') .
                ($this->fragment ? '#' . $this->fragment : '');
    }

    public function __toString()
    {
        return $this->toString();
    }
}
