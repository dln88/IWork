<?php


namespace App\Repositories;


use App\Models\WorkDate;
use Prettus\Repository\Eloquent\BaseRepository;

class WorkDateRepository extends BaseRepository
{
    public function model()
    {
        return WorkDate::class;
    }

}