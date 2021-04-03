<?php

namespace App\Http\Controllers\Api;

use App\Dto\UserInfo\UserInfoListRequestDto;
use App\Dto\UserInfo\UserInfoSaveRequestDto;
use App\Exceptions\UserInfoNotUniqueFioException;
use App\Exceptions\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfo\UserInfoListRequest;
use App\Http\Requests\UserInfo\UserInfoSaveRequest;
use App\Http\Resources\UserInfo\UserInfoListResource;
use App\Http\Resources\UserInfo\UserInfoSaveResource;
use App\Services\UserInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserInfoController extends Controller
{
    /**
     * @var UserInfoService
     */
    private UserInfoService $userInfoService;

    public function __construct(UserInfoService $userInfoService)
    {
        $this->userInfoService = $userInfoService;
    }

    /**
     * @param UserInfoSaveRequest $request
     * @return JsonResponse
     * @throws UserInfoNotUniqueFioException
     * @throws ValidationException
     */
    public function save(UserInfoSaveRequest $request) : JsonResponse
    {
        return $this->response(
            'Сохранение информации о пользователе',
                new UserInfoSaveResource(['success' => $this->userInfoService->save(new UserInfoSaveRequestDto(
                    auth()->user()->id,
                    $request->get('name'),
                    $request->get('surname'),
                    $request->get('patronymic'),
                    $request->get('email'),
                    $request->get('phone'),
                    $request->get('type'),
            ))])
        );
    }

    /**
     * @param UserInfoListRequest $request
     * @param int $userId
     * @return JsonResponse
     */
    public function list(UserInfoListRequest $request, int $userId): JsonResponse
    {
        $userInfoList = $this->userInfoService->list(new UserInfoListRequestDto(
            $userId,
            $request->get('type')
        ));
        return $this->response(
            'Сохранение информации о пользователе',
            UserInfoListResource::collection($userInfoList->getUserInfoList())
        );
    }
}
