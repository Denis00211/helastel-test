<?php

namespace App\Factories;

use App\Repositories\CacheUserInfoRepository;
use App\Repositories\DBUserInfoRepository;
use App\Repositories\JsonUserInfoRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\XlsxUserInfoRepository;
use RuntimeException;

class UserInfoRepositoryFactory
{
    public const TYPE_DB = 'db';
    public const TYPE_CACHE = 'cache';
    public const TYPE_JSON = 'json';
    public const TYPE_XLSX = 'xlsx';

    /**
     * @return string[]
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_DB,
            self::TYPE_CACHE,
            self::TYPE_JSON,
            self::TYPE_XLSX,
        ];
    }

    /**
     * @param $type
     * @return UserInfoRepository
     */
    public static function build($type): UserInfoRepository
    {
        switch ($type) {
            case self::TYPE_DB:
                return new DBUserInfoRepository();
            case self::TYPE_CACHE:
                return new CacheUserInfoRepository();
            case self::TYPE_JSON:
                return new JsonUserInfoRepository();
            case self::TYPE_XLSX:
                return new XlsxUserInfoRepository();
        }

        throw new RuntimeException("Invalid type given.");
    }
}
