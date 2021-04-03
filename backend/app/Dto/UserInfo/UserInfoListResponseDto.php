<?php

namespace App\Dto\UserInfo;

class UserInfoListResponseDto
{
    /**
     * @var array
     */
    private $userInfoList;

    /**
     * UserInfoList constructor.
     * @param array $userInfoList
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
