<?php

namespace App\Http\Requests\UserInfo;

use App\Factories\UserInfoRepositoryFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserInfoSaveRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'patronymic' => ['required', 'string'],
            'email' => ['required', 'email', 'string'],
            'phone' => ['required', 'string'],
            'type' => [
                'required',
                'string',
                Rule::in(UserInfoRepositoryFactory::getTypes()),
            ],
        ];
    }
}
