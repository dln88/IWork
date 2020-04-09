<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    /**
     * Get user function
     *
     * @param string $userId
     * @return collection
     */
    public function getUser(string $userId);

    /**
     * Check role of user function
     *
     * @param int $operatorCD
     * @return collection
     */
    public function checkRole(int $operatorCD);
}