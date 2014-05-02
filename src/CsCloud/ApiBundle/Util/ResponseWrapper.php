<?php

namespace CsCloud\ApiBundle\Util;

use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\Annotation as JMS;

/**
 * Response wrapper for Api xml response
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class ResponseWrapper
{
    protected $status;
    protected $message;
    protected $data;

    /**
     * Get a human-readable HTTP status message
     *
     * @param integer $statusCode
     * @return string
     */
    public static function getStatusMessage($statusCode)
    {
        if (isset(Response::$statusTexts[$statusCode])) {
            return Response::$statusTexts[$statusCode];
        }

        if (isset(ResponseStatus::$statusTexts[$statusCode])) {
            return ResponseStatus::$statusTexts[$statusCode];
        }

        return 'Unknown';
    }

    /**
     * Creates a response wrapper object
     *
     * @param integer $statusCode HTTP status code
     * @param mixed $data A serializable object
     */
    public function __construct($statusCode, $data) {
        $this->status = $statusCode;
        $this->message = static::getStatusMessage($statusCode);
        $this->data = $data;
    }
}
