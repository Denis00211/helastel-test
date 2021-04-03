<?php

namespace App\Repositories;

use App\Dto\UserInfo\UserInfoListResponseDto;
use App\Dto\UserInfo\UserInfoResponseDto;
use App\Dto\UserInfo\UserInfoSaveRequestDto;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class XlsxUserInfoRepository implements UserInfoRepository
{
    private const NAME = 1;
    private const SURNAME = 2;
    private const PATRONYMIC = 3;
    private const EMAIL = 4;
    private const PHONE = 5;

    public function save(UserInfoSaveRequestDto $userInfoSave): bool
    {
        $fileName = $this->getFileName($userInfoSave->getUserId());
        $userInfoSpreadsheet = Storage::disk('local')->exists($fileName) ?
            (new Xlsx())->load(storage_path('app/' ) . $fileName)
            : new Spreadsheet();

        $lastLine = $userInfoSpreadsheet->getActiveSheet()->getHighestRow();

        $name = $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::NAME, $lastLine)->getValue();
        if($name) {
            $lastLine++;
        }
        $userInfoSpreadsheet->getActiveSheet()->setCellValueByColumnAndRow(self::NAME, $lastLine,  $userInfoSave->getName());
        $userInfoSpreadsheet->getActiveSheet()->setCellValueByColumnAndRow(self::SURNAME, $lastLine,  $userInfoSave->getSurname());
        $userInfoSpreadsheet->getActiveSheet()->setCellValueByColumnAndRow(self::PATRONYMIC, $lastLine,  $userInfoSave->getPatronymic());
        $userInfoSpreadsheet->getActiveSheet()->setCellValueByColumnAndRow(self::EMAIL, $lastLine,  $userInfoSave->getEmail());
        $userInfoSpreadsheet->getActiveSheet()->setCellValueByColumnAndRow(self::PHONE, $lastLine,  $userInfoSave->getPhone());

        $writer = new WriterXlsx($userInfoSpreadsheet);
        try {
            $writer->save(storage_path('app/' ) . $fileName);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function list(int $userId): UserInfoListResponseDto
    {
        $fileName = $this->getFileName($userId);

        if(!Storage::disk('local')->exists($fileName)) {
            return new UserInfoListResponseDto([]);
        }

        $userInfoSpreadsheet = (new Xlsx())->load(storage_path('app/' ) . $fileName);

        $highestRow = $userInfoSpreadsheet->getActiveSheet()->getHighestRow();
        $userInfoList = [];
        for ($row = 1; $row <= $highestRow; ++$row) {
            $userInfoList[] = new UserInfoResponseDto(
                $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::NAME, $row)->getValue(),
                $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::SURNAME, $row)->getValue(),
                $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::PATRONYMIC, $row)->getValue(),
                $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::EMAIL, $row)->getValue(),
                $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::PHONE, $row)->getValue(),
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

        $userInfoSpreadsheet = (new Xlsx())->load(storage_path('app/' ) . $fileName);

        $highestRow = $userInfoSpreadsheet->getActiveSheet()->getHighestRow();
        for ($row = 1; $row <= $highestRow; ++$row) {
            $nameXlsx = $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::NAME, $row)->getValue();
            $surnameXlsx = $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::SURNAME, $row)->getValue();
            $patronymicXlsx = $userInfoSpreadsheet->getActiveSheet()->getCellByColumnAndRow(self::PATRONYMIC, $row)->getValue();

            if(
                $nameXlsx === $name &&
                $surnameXlsx === $surname &&
                $patronymicXlsx ===  $patronymic
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
        return 'user_info_user_id_' . $userId . '.xlsx';
    }
}
