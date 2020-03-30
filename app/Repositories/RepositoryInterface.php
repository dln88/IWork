<?php

namespace App\Repositories;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    public function all();

    public function find(array $data);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}
