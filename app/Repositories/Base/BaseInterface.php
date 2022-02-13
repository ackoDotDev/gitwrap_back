<?php

namespace App\Repositories\Base;

interface BaseInterface
{
    /**
     * @param array $filters
     * @param array $select
     * @param array $relationships
     * @return mixed
     */
    public function findByFilters(array $filters, array $select, array $relationships);

    /**
     * @param string|int $id
     * @return mixed
     */
    public function findById(mixed $id);

    /**
     * @param array $filters
     * @param array $select
     * @param array $relationships
     * @return mixed
     */
    public function findOneByFilters(array $filters, array $select, array $relationships);


    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments);
}
