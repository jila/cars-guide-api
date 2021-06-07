<?php
namespace App\Repositories;

use App\Contracts\CarModelRepositoryInterface;
use App\Models\CarMake;
use Illuminate\Database\Eloquent\Model;

class CarModelRepository extends BaseRepository implements CarModelRepositoryInterface
{
    protected $carMake;

    public function __construct(Model $model, CarMake $carMake)
    {
        $this->carMake = $carMake;
        parent::__construct($model);
    }

    public function getCarModels(array $attributes): array
    {
        $carModel = $this->model->query();

        if (isset($attributes['make'])) {
            $carModel = $carModel->where('model', 'like', '%' . $attributes['model'] . '%');
        }

        if (isset($attributes['car_make_id'])) {
            $carModel = $carModel->where('car_make_id', $attributes['car_make_id']);
        }

        return $carModel->get()->toArray();
    }

    /**
     * override the parent method as it is going to use belongs to
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $make = $this->carMake->find($attributes['car_make_id']);
        $this->model->carMake()->associate($make);
        return $this->model->create($attributes);
    }
}
