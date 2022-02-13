<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function findByFilters(array $filters, array $select, array $relationships)
    {
        // TODO: Implement findByFilters() method.
    }

    /**
     * @inheritDoc
     */
    public function findById(mixed $id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function findOneByFilters(array $filters, array $select, array $relationships)
    {
        // TODO: Implement findOneByFilters() method.
    }

    /**
     * @inheritDoc
     */
    public function __call(string $name, array $arguments)
    {
        return $this->model->$name(...$arguments);
    }
}
