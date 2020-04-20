<?php

namespace App\Repositories\Interfaces;

interface AdminWorkRepositoryInterface
{
    public function getPostCD();
    public function getTimeList($page = 1);
    public function getTimeListByCondition($page = 1, array $validatedData);
    public function getUserByKey(int $id);
    public function getMonthlyReport($id, $yearMonth = '202004');
    public function getAttendanceByDate($id, $date);
    public function getVacationInformationByDate($id, $date);
}