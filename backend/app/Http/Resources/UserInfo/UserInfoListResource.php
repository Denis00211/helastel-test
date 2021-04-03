<?php

namespace App\Http\Resources\UserInfo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method getName()
 * @method getSurname()
 * @method getPatronymic()
 * @method getEmail()
 * @method getPhone()
 */
class UserInfoListResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'patronymic' => $this->getPatronymic(),
            'email' => $this->getEmail(),
            'phone' =>  $this->getPhone(),
        ];
    }
}
