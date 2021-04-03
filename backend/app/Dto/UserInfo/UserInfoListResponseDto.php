<?php

namespace App\Dto\UserInfo;

class UserInfoListResponseDto
{
    /**
     * @var array
     */
    private array $userInfoList;

    /**
     * UserInfoList constructor.
     * @param UserInfoResponseDto[] $userInfoList
     */
    public function __construct(array $userInfoList)
    {
        $this->userInfoList = $userInfoList;
    }

    /**
     * @return array
     */
    public function getUserInfoList(): array
    {
        return $this->userInfoList;
    }
}
