<?php

namespace CsCloud\ApiBundle\View;

use Symfony\Component\HttpFoundation\Response as BaseResponse;
use CsCloud\ApiBundle\Util\ResponseWrapper;

class Response extends BaseResponse
{
    /**
     * Sets the response status code.
     *
     * @param integer $code HTTP status code
     * @param mixed   $text HTTP status text
     *
     * If the status text is null it will be automatically populated for the known
     * status codes and left empty otherwise.
     *
     * @return Response
     *
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     *
     * @api
     */
    public function setStatusCode($code, $text = null)
    {
        $this->statusCode = $code = (int) $code;
        if ($this->isInvalid()) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $code));
        }

        if (null === $text) {
            $this->statusText = ResponseWrapper::getStatusMessage($code);

            return $this;
        }

        if (false === $text) {
            $this->statusText = '';

            return $this;
        }

        $this->statusText = $text;

        return $this;
    }
}
