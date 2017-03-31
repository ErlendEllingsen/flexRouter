<?php

namespace FlexRouter\Exceptions;

use Exception;

class ParameterNotFoundException extends Exception
{
    /**
     * ParameterNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}