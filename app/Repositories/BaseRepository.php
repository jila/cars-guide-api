<?php
namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }

    public function get(): array
    {
        // TODO: Implement get() method.
    }
}
