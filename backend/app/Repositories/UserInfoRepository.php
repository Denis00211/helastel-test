<?php

namespace App\Repositories;

use App\Dto\UserInfo\UserInfoListResponseDto;
use App\Dto\UserInfo\UserInfoSaveRequestDto;
use App\Exceptions\ValidationException;

interface UserInfoRepository
{
    /**
     * @param UserInfoSaveRequestDto $userInfoSave
     * @return bool
     *@throws ValidationException
     */
    public function save(UserInfoSaveRequestDto $userInfoSave): bool;

    /**
     * @param int $userId
     * @return UserInfoListResponseDto
     */
    public function list(int $userId):UserInfoListResponseDto;

    /**
     * @param int $userId
     * @param string $name
     * @param string $surname
     * @param string $patronymic
     * @return mixed
     */
    public function checkUniqueFio(int $userId, string $name, string $surname, string $patronymic): bool;
}
