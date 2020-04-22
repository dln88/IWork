<?php

namespace App\Repositories\Interfaces;

interface AdminWorkRepositoryInterface
{
    public function getPostCD();
    public function getTimeListByCondition(array $validatedData);
    public function getUserByKey(int $id);
    public function getMonthlyReport($id, $yearMonth);
    public function getAttendanceByDate($id, $date);
    public function getVacationInformationByDate($id, $date);
    public function findWorkDate($id, $date);
    public function updateWorkDate($id, $data);
    public function insertWorkDate($id, $data);
    public function updateVacation($id, $data);
}