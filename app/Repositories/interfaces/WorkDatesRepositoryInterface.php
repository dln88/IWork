<?php

namespace App\Repositories\Interfaces;

interface WorkDatesRepositoryInterface
{
    /**
    * Get start time and end time of the post which post_cd given.
    *
    * @param integer $postCd
    * @return collection
    */
    public function getTimePost(int $postCd);
    
    /**
    * Get work dates of user which operator_cd given.
    *
    * @param integer $operatorCd
    * @param string $firstDayofMonth
    * @param string $lastDayofMonth
    * @return collection
    */
    public function getWorkDates(int $operatorCd, $firstDayofMonth, $lastDayofMonth);

    /**
     * Whether the total overtime hours exceeds the warning overtime hours limit.
     *
     * @param integer $operatorCd
     * @param string $firstDayofMonth
     * @param string $lastDayofMonth
     * @return boolean
     */
    public function isOverTime(int $operatorCd, $firstDayofMonth, $lastDayofMonth);

    /**
     * Check attendance information of current user.
     *
     * @param integer $operatorCd
     * @return boolean
     */
    public function checkAttendanceTime(int $operatorCd);

    /**
     * Regist attendance time of current user.
     *
     * @param integer $operatorCd
     * @param string $attTime
     * @return collection
     */
    public function registerAttendanceTime(int $operatorCd, string $attTime);

    /**
     * whether leave time greater than attendance time
     *
     * @param integer $operatorCd
     * @param string $endTime
     * @return boolean
     */
    public function checkEndTimeGreaterStartTime(int $operatorCd, string $endTime);

    /**
     * Check leave information of current user.
     *
     * @param integer $operatorCd
     * @return boolean
     */
    public function checkLeaveTime(int $operatorCd);
    
    /**
     * Get start time attendance of current user.
     *
     * @param integer $operatorCd
     * @param string $currentDate
     * @return collection
     */
    public function getStartTimeandEndTime(int $operatorCd, string $currentDate);

    /**
     * Regist leave time of current user.
     *
     * @param integer $operatorCd
     * @param string $endTime
     * @param string $currentDate
     * @return boolean
     */
    public function registLeaveTime(int $operatorCd, string $endTime, string $currentDate);

    /**
     *  Caculate working time, break time, overtime, late night overtime and save them to db.
     *
     * @param int $operatorCd
     * @param string $currentDate
     * @return boolean
     */
    public function caculateAndRegistTime(int $operatorCd, string $currentDate);
}