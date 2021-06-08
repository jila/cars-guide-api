<?php
namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param array $condition
     * @return int
     */
    public function update(array $attributes, array $condition): int
    {
        $query = $this->model->query();

        foreach ($condition as $field => $value) {
            if (!is_null($value)) {
                $query = $query->where($field, $value);
            }
        }
        return $query->update($attributes);
    }

    public function delete(array $condition): bool
    {
        $query = $this->model->query();

        foreach ($condition as $field => $value) {
            if (!is_null($value)) {
                $query = $query->where($field, $value);
            }
        }
    }

    public function get(): array
    {
        // TODO: Implement get() method.
    }
}
