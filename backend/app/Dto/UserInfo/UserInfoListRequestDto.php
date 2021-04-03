<?php

namespace App\Dto\UserInfo;

class UserInfoListRequestDto
{
    /**
     * @var int
     */
    private $userId;
    /**
     * @var string
     */
    private $type;

    public function __construct(int $userId, string $type)
    {
        $this->userId = $userId;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
