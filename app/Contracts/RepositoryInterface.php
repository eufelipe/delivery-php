<?php

namespace App\Contracts;

interface RepositoryInterface
{

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ["*"]);


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);


    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id);


    /**
     * @param $id
     * @return mixed
     */
    public function delete(int $id);


    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find(int $id, $columns = ["*"]);


    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy(string $field, string $value, $columns = ["*"]);
}
