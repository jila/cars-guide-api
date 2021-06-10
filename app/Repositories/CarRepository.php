<?php
namespace App\Repositories;

use App\Contracts\CarRepositoryInterface;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CarRepository extends BaseRepository implements CarRepositoryInterface
{
    protected $carMake;

    protected $carModel;

    /**
     * CarRepository constructor.
     * @param Model    $model
     * @param CarMake  $carMake
     * @param CarModel $carModel
     */
    public function __construct(Model $model, CarMake $carMake, CarModel $carModel)
    {
        $this->carMake = $carMake;
        $this->carModel = $carModel;
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @param array $pagination
     * @return array
     */
    public function findCars(array $attributes = [], array $pagination = []): array
    {
        $carQuery = $this->model->query();

        foreach ($attributes as $field => $attribute) {
            if (!is_null($attribute)) {
                $carQuery = $carQuery->where($field, $attribute);
            }
        }

        // Clone the $carQuery to get the total number of the rows with the condition
        $queryTotal = $carQuery->clone();
        $totalNumber = $queryTotal->count();

        if (isset($pagination['limit']) && isset($pagination['page'])) {
            $offset = ((int) $pagination['page'] - 1) * (int) $pagination['limit'];
            $carQuery = $carQuery->limit($pagination['limit'])->offset($offset);
        }

        $cars = $carQuery->get();

        // now it is time to loop through Collection and get carMake and carModel
        foreach ($cars as $car) {
            $car->carMake->model;
            $car->carModel->make;
        }

        return [
            'rows' => $cars->toArray(),
            'total' => $totalNumber
        ];
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $make = $this->carMake->find($attributes['car_make_id']);
        $this->model->carMake()->associate($make);

        $model = $this->carModel->find($attributes['car_model_id']);
        $this->model->carModel()->associate($model);

        return $this->model->create($attributes);
    }
}
