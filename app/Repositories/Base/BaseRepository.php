<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function deleteWhere(array $filters): mixed
    {
        return $this->model->where($filters)->delete();
    }

    /**
     * @inheritDoc
     */
    public function __call(string $name, array $arguments)
    {
        return $this->model->$name(...$arguments);
    }
}
