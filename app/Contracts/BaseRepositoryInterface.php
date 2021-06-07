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
     * @return bool
     */
    public function update(array $attributes): Bool;

    /**
     * @return bool
     */
    public function delete(): bool;

    /**
     * @return array
     */
    public function get(): array;
}
