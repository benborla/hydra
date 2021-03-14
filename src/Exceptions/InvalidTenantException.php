<?php

declare(strict_types=1);

namespace Benborla\Hydra\Exceptions;

use RuntimeException;

class InvalidTenantException extends RuntimeException
{
    public function __construct($tenant, $code = 1)
    {
        $message = "$tenant is not configured properly, hydra configuration is missing in composer.json";
        parent::__construct($message, $code);
    }
}
