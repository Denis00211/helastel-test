<?php

namespace App\Exceptions;

class UserInfoNotUniqueFioException extends BaseException
{
    public function __construct(
        string $message = 'User fio is not unique',
        int $code = 401,
        array $data = []
    ) {
        parent::__construct($message, $code, [], null, $data);
    }
}
