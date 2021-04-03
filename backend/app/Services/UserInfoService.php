<?php

namespace App\Services;

use App\Dto\UserInfo\UserInfoListRequestDto;
use App\Dto\UserInfo\UserInfoListResponseDto;
use App\Dto\UserInfo\UserInfoSaveRequestDto;
use App\Exceptions\UserInfoNotUniqueFioException;
use App\Exceptions\ValidationException;
use App\Factories\UserInfoRepositoryFactory;

class UserInfoService
{
    /**
     * @param UserInfoSaveRequestDto $dto
     * @return bool
     * @throws UserInfoNotUniqueFioException|ValidationException
     */
    public function save(UserInfoSaveRequestDto $dto): bool
    {
        $repository = UserInfoRepositoryFactory::build($dto->getType());

        if(!$repository->checkUniqueFio(
            $dto->getUserId(),
            $dto->getName(),
            $dto->getSurname(),
            $dto->getPatronymic())
        ) {
            throw new UserInfoNotUniqueFioException();
        }

        return $repository->save($dto);
    }

    /**
     * @param UserInfoListRequestDto $dto
     * @return UserInfoListResponseDto
     */
    public function list(UserInfoListRequestDto $dto): UserInfoListResponseDto
    {
        $repository = UserInfoRepositoryFactory::build($dto->getType());

        return $repository->list($dto->getUserId());
    }
}
