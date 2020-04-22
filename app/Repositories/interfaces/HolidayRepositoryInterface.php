<?php

namespace App\Repositories\Interfaces;

interface HolidayRepositoryInterface
{
    public function getVacationList();
    public function getPaidVacationDays();
    public function getDaysOff(string $targetStart, string $targetEnd);
    public function getHolidayLeaveDays();
    public function getNumberOfDaysOff(string $targetStart, string $targetEnd);
    public function registHoliday(array $data);
    public function checkExistRegisterDate(string $dateRegister);
}
