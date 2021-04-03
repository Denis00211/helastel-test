<?php

namespace App\Http\Requests\UserInfo;

use App\Factories\UserInfoRepositoryFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserInfoListRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                Rule::in(UserInfoRepositoryFactory::getTypes()),
            ],
        ];
    }
}
