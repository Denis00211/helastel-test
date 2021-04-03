<?php

namespace App\Repositories;

use App\Dto\UserInfo\UserInfoListResponseDto;
use App\Dto\UserInfo\UserInfoResponseDto;
use App\Dto\UserInfo\UserInfoSaveRequestDto;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use JsonException;

class JsonUserInfoRepository implements UserInfoRepository
{
    /**
     * @param UserInfoSaveRequestDto $userInfoSave
     * @return bool
     * @throws FileNotFoundException
     * @throws JsonException
     */
    public function save(UserInfoSaveRequestDto $userInfoSave): bool
    {
        $fileName = $this->getFileName($userInfoSave->getUserId());
        $userInfo = Storage::disk('local')->exists($fileName) ?
            json_decode(Storage::disk('local')->get($fileName), true, 512, JSON_THROW_ON_ERROR)
            : [];

        $userInfo[] = [
            'name' => $userInfoSave->getName(),
            'surname' => $userInfoSave->getSurname(),
            'patronymic' => $userInfoSave->getPatronymic(),
            'email' => $userInfoSave->getEmail(),
            'phone' => $userInfoSave->getPhone(),
        ];

        return Storage::disk('local')->put($fileName, json_encode($userInfo, JSON_THROW_ON_ERROR));
    }

    public function list(int $userId): UserInfoListResponseDto
    {
        $fileName = $this->getFileName($userId);

        if(!Storage::disk('local')->exists($fileName)) {
            return new UserInfoListResponseDto([]);
        }

        $userInfo = json_decode(Storage::disk('local')->get($fileName), true, 512, JSON_THROW_ON_ERROR);

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
        $fileName = $this->getFileName($userId);

        if(!Storage::disk('local')->exists($fileName)) {
            return true;
        }

        $userInfo = json_decode(Storage::disk('local')->get($fileName), true, 512, JSON_THROW_ON_ERROR);

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

    /**
     * @param $userId
     * @return string
     */
    private function getFileName(int $userId): string
    {
        return 'user_info_user_id_' . $userId . '.json';
    }
}
