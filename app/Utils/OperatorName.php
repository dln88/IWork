<?php

namespace App\Utils;

class OperatorName
{
    /**
     * Get full name of operator.
     * 
     * @param array $data
     */
    public static function operatorName(array $data) {
        if (isset($data['operator_last_name']) && isset($data['operator_first_name'])) {
            return $data['operator_last_name']. " ". $data['operator_first_name'];
        }
        return null;
    }
}