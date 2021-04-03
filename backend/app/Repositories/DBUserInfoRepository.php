<?php

namespace App\Repositories;

use App\Dto\UserInfo\UserInfoListResponseDto;
use App\Dto\UserInfo\UserInfoResponseDto;
use App\Dto\UserInfo\UserInfoSaveRequestDto;
use App\Models\UserInfo;
use Throwable;

class DBUserInfoRepository implements UserInfoRepository
{
    public function list(int $userId): UserInfoListResponseDto
    {
        $userInfoItems = UserInfo::query()->where(['user_id' => $userId])->get();

        $userInfoList = [];
        foreach ($userInfoItems as $userInfoItem) {
            $userInfoList[] = new UserInfoResponseDto(
                $userInfoItem->name,
                $userInfoItem->surname,
                $userInfoItem->patronymic,
                $userInfoItem->email,
                $userInfoItem->phone,
            );
        }

        return new UserInfoListResponseDto($userInfoList);
    }

    /**
     * @param UserInfoSaveRequestDto $userInfoSave
     * @return bool
     * @throws Throwable
     */
    public function save(UserInfoSaveRequestDto $userInfoSave): bool
    {
        $userInfo = new UserInfo();
        $userInfo->name = $userInfoSave->getName();
        $userInfo->surname = $userInfoSave->getSurname();
        $userInfo->patronymic = $userInfoSave->getPatronymic();
        $userInfo->email = $userInfoSave->getEmail();
        $userInfo->phone = $userInfoSave->getPhone();
        $userInfo->user_id = $userInfoSave->getUserId();

        return $userInfo->saveOrFail();
    }

    public function checkUniqueFio(int $userId, string $name, string $surname, string $patronymic): bool
    {
        return !UserInfo::query()->where([
            'user_id' => $userId,
            'name' => $name,
            'surname' => $surname,
            'patronymic' => $patronymic
        ])->exists();
    }
}
