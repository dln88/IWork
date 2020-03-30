<?php


namespace App\Repositories;


use App\Models\Vacation;
use Prettus\Repository\Eloquent\BaseRepository;

class VacationRepository extends BaseRepository
{
    public function model()
    {
        return Vacation::class;
    }

}