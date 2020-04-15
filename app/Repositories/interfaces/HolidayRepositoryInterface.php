<?php

namespace App\Repositories\Interfaces;

interface HolidayRepositoryInterface
{
    public function getVacationList();
    public function getPaidVacationDays();
    public function getDaysOff($targetStart, $targetEnd);
    public function getHolidayLeaveDays();
    public function getNumberOfDaysOff($targetStart, $targetEnd);
    public function registHoliday(array $data);
    public function checkExistRegisterDate(string $dateRegister);
}
