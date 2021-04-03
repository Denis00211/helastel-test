<?php

namespace App\Exceptions;

class AuthorizationException extends BaseException
{
    public function __construct(
        string $message = 'Unauthorized',
        int $code = 401,
        array $data = []
    ) {
        parent::__construct($message, $code, [], null, $data);
    }
}
