<?php

namespace Tests\Feature;

use App\Contracts\CarMakeRepositoryInterface;
use App\Contracts\CarModelRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App;

class CarModelApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_car_model_with_missing_param()
    {
        $this->json('POST', '/api/car-model', ['model' => 'test car model missing make_id'])
            ->assertStatus(400)
            ->assertJson(['message' => 'Please provide Make']);
    }

    public function test_create_car_model()
    {
        // First create a car_make then use the ID to create new model
        $carMakeNameRandom = 'car make ' . bin2hex(random_bytes(5));

        $response = $this->json('POST', '/api/car-make', ['make' => $carMakeNameRandom]);
        $newMakeId = $response->original['data']['value'];

        $this->json('POST', '/api/car-model', ['model' => 'test car model', 'make_id' => $newMakeId])
             ->assertStatus(200)
             ->assertJsonStructure(['data' => ['value', 'label']]);
    }

    public function test_duplicate_car_model()
    {
        $carMakeNameRandom = 'car make ' . bin2hex(random_bytes(5));
        $carModelNameRandom = 'car model ' . bin2hex(random_bytes(5));

        // First create the car_make
        $carMakeRepo = App::make(CarMakeRepositoryInterface::class);
        $newCarMake  = $carMakeRepo->create(['make' => $carMakeNameRandom]);

        // then create a car_model
        $carModelRepo = App::make(CarModelRepositoryInterface::class);
        $newCarModel  = $carModelRepo->create([
            'car_make_id' => $newCarMake->id,
            'model'   => $carModelNameRandom
        ]);

        // again create the same record
        $this->json('POST', '/api/car-model',
            [
                'model' => $carModelNameRandom,
                'make_id' => $newCarMake->id
            ])->assertStatus(200)
            ->assertJsonFragment(['data' => ['value' => $newCarModel->id, 'label' => $carModelNameRandom]]);
    }

    public function test_get_car_models_by_make_id()
    {
        // First create the car_make
        $carMakeNameRandom = 'car make ' . bin2hex(random_bytes(5));
        $carModelNameRandom1 = 'a car model 1 ' . bin2hex(random_bytes(5));
        $carModelNameRandom2 = 'b car model 2 ' . bin2hex(random_bytes(5));

        $carMakeRepo = App::make(CarMakeRepositoryInterface::class);
        $newCarMake  = $carMakeRepo->create(['make' => $carMakeNameRandom]);

        // then create a car_model
        $carModelRepo = App::make(CarModelRepositoryInterface::class);
        $newCarModel1  = $carModelRepo->create([
            'car_make_id' => $newCarMake->id,
            'model'   => $carModelNameRandom1
        ]);

        $newCarModel2  = $carModelRepo->create([
            'car_make_id' => $newCarMake->id,
            'model'   => $carModelNameRandom2
        ]);

        $this->json('GET', '/api/car-model', ['make_id' => $newCarMake->id])
            ->assertStatus(200)
            ->assertExactJson([
                ['label' => $carModelNameRandom1, 'value' => $newCarModel1->id],
                ['label' => $carModelNameRandom2, 'value' => $newCarModel2->id],
        ]   );
    }
}
