<?php

declare(strict_types=1);


namespace App\Helpers\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class NullPointerException extends Exception
{
    #[Pure]
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
        parent::__construct('NullPointerException: '.$message, $code, $previous);
    }
}
