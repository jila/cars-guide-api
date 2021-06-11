<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CarMakeApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_car_make_api()
    {
        $this->json('POST', '/api/car-make', ['make' => 'test car make'])
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['value', 'label']]);
    }

    public function test_car_make_missing_input()
    {
        $this->json('POST', '/api/car-make', ['make' => ''])
            ->assertStatus(400)
            ->assertJsonStructure(['message']);
    }

    public function test_get_cars()
    {
        $this->json('GET', '/api/car-make')
            ->assertStatus(200)
            ->assertJsonStructure(['*' => ['value', 'label']]);
    }

    public function test_create_duplicate_car_make()
    {
        $carMakeNameRandom = 'test duplicate car make ' . bin2hex(random_bytes(5));

        $response = $this->json('POST', '/api/car-make', ['make' => $carMakeNameRandom]);
        $newRecordId = $response->original['data']['value'];

        $this->json('POST', '/api/car-make', ['make' => $carMakeNameRandom])
             ->assertStatus(200)
             ->assertJsonFragment(['data' => ['value' => $newRecordId, 'label' => $carMakeNameRandom]]);
    }
}
