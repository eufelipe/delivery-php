<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $this->setupModel();
    }

    /**
     * Setup
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function setupModel()
    {
        $model = $this->model();
        $this->model = new $model;
        return $this->model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function instance()
    {
        return $this->model;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ["*"])
    {
        return $this->model->get($columns);
    }

    /**
     * Creates a new record
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }


    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find(int $id, $columns = ["*"])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->find($id);
        return $model->delete();
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ["*"])
    {
        return $this->model->where($field, '=', $value)->get($columns);
    }


    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function like($field, $value, $columns = ["*"])
    {
        return $this->model->where($field, 'like', '%' . $value . '%')->get($columns);
    }


}
