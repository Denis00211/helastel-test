<?php

namespace App\Repositories;

use App\Dto\UserInfo\UserInfoListResponseDto;
use App\Dto\UserInfo\UserInfoResponseDto;
use App\Dto\UserInfo\UserInfoSaveRequestDto;
use Illuminate\Support\Facades\Cache;

class CacheUserInfoRepository implements UserInfoRepository
{
    public function save(UserInfoSaveRequestDto $userInfoSave): bool
    {
        $cacheName = 'user_info_user_id_'.$userInfoSave->getUserId();

        $userInfo = Cache::get($cacheName);

        $userInfo[] = [
            'name' => $userInfoSave->getName(),
            'surname' => $userInfoSave->getSurname(),
            'patronymic' => $userInfoSave->getPatronymic(),
            'email' => $userInfoSave->getEmail(),
            'phone' => $userInfoSave->getPhone(),
        ];

        return Cache::has($cacheName) ? Cache::put($cacheName, $userInfo) : Cache::add($cacheName, $userInfo);
    }

    public function list(int $userId): UserInfoListResponseDto
    {
        $cacheName = 'user_info_user_id_'.$userId;
        if(!Cache::has($cacheName)) {
            return new UserInfoListResponseDto([]);
        }

        $userInfo = Cache::get($cacheName);

        $userInfoList = [];
        foreach ($userInfo as $userInfoItem) {
            $userInfoList[] = new UserInfoResponseDto(
                $userInfoItem['name'],
                $userInfoItem['surname'],
                $userInfoItem['patronymic'],
                $userInfoItem['email'],
                $userInfoItem['phone'],
            );
        }

        return new UserInfoListResponseDto($userInfoList);
    }

    public function checkUniqueFio(int $userId, string $name, string $surname, string $patronymic): bool
    {
        $cacheName = 'user_info_user_id_'.$userId;
        if(!Cache::has($cacheName)) {
            return true;
        }

        $userInfo = Cache::get($cacheName);

        foreach ($userInfo as $item) {
            if(
                $item['name'] === $name &&
                $item['surname'] === $surname &&
                $item['patronymic'] ===  $patronymic
            )
            {
                return false;
            }
        }

        return true;
    }
}
