<?php

namespace App\Dto\UserInfo;

class UserInfoSaveRequestDto
{
    /**
     * @var string
     */
    private $patronymic;
    /**
     * @var string
     */
    private $surname;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $userId;

    /**
     * UserInfoList constructor.
     * @param int $userId
     * @param string $name
     * @param string $surname
     * @param string $patronymic
     * @param string $email
     * @param string $phone
     * @param string $type
     */
    public function __construct(int $userId, string $name, string $surname, string $patronymic, string $email, string $phone, string $type)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
        $this->email = $email;
        $this->phone = $phone;
        $this->type = $type;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
