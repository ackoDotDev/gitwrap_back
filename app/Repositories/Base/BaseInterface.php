<?php

namespace App\Repositories\Base;

interface BaseInterface
{
    /**
     * @param array $filters
     * @return mixed
     */
    public function deleteWhere(array $filters): mixed;

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments);
}
