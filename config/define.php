<?php

return [
    'operation_type' => [
        'login' => 1,
        'logout' => 2
    ],
    'admin_div' => [
        'user' => 0,
        'admin' => 1
    ],
    'alert_over_time' => [
        'max' => 80,
        'message' => '警告する残業時間規定値'
    ],
    'holiday_rows' => [
        'max' => 20,
        'message' => '休暇登録の最大行数'
    ],
    'work_admin_rows' => [
        'max' => 30,
        'message' => '管理者勤怠一覧の最大行数'
    ],
    'closing_date' => [
        'max' => 15,
        'message' => '会社としての勤怠締日　※1/10/15/20/25/末日（99）の選択制を前提とする。'
    ],
    'max_leave_time' => [
        'max' => 34,
        'message' => '退勤時間登録最大値　※翌日9時を最大値とする。（飯田商事様要望）'
    ],
    'holiday_past_mm' => [
        'max' => 6,
        'message' => '休暇登録の休暇一覧表示に過去何か月分を表示するかを設定'
    ],
    'holiday_app_past_mm' => [
        'max' => 1,
        'message' => '休暇申請可能最大過去月'
    ],
    'holiday_app_fu_mm' => [
        'max' => 3,
        'message' => '休暇申請可能最大未来月'
    ],
];