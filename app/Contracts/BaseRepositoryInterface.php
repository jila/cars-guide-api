<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param array $attributes
     * @param array $condition
     * @return bool
     */
    public function update(array $attributes, array $condition): int;

    /**
     * @param array $condition
     * @return bool
     */
    public function delete(array $condition): bool;

    /**
     * @return array
     */
    public function get(): array;
}
