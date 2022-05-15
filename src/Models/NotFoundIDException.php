<?php

namespace Adil\SpinitPhp\Models;

use Throwable;

class NotFoundIDException extends \Exception
{
    public function __construct($message = "", $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}