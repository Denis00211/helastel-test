<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @param $id
     * @return User
     */
    public function me($id): User
    {
        return User::query()->select(['id', 'email'])->where(['id' => $id])->firstOrFail();
    }
}
