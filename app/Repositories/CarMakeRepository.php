<?php
namespace App\Repositories;

use App\Contracts\CarMakeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CarMakeRepository extends BaseRepository implements CarMakeRepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    /**
     * gets an string and return an array of carMakes that has similar name
     * this method will return a key => value array
     * @param array $attributes
     * @return array
     */
    public function getCarMakes(array $attributes): array
    {
        $carMakeModel = $this->model->query();

        if (isset($attributes['make'])) {
            $carMakeModel = $carMakeModel->where('make', 'like', '%' . $attributes['make'] . '%');
        }

        return $carMakeModel->get()->toArray();
    }
}
