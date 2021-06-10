<?php

namespace Database\Seeders;

use App\Contracts\CarMakeRepositoryInterface;
use App\Contracts\CarModelRepositoryInterface;
use App\Contracts\CarRepositoryInterface;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param CarMakeRepositoryInterface $carMakeRepo
     * @param CarModelRepositoryInterface $carModelRepo
     * @param CarRepositoryInterface $carRepo
     * @return void
     */
    public function run(CarMakeRepositoryInterface $carMakeRepo, CarModelRepositoryInterface $carModelRepo, CarRepositoryInterface $carRepo)
    {
        // This will read the csv file and fills car_makes, car_models, cars tables
        $handle = fopen(storage_path() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'vehicles.csv', 'r');

        if (!$handle) {
            return;
        }

        $firstLine = true;
        while (($row = fgetcsv($handle, ',')) !== false) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }

            if ($row[1]) {
                $newCarMake = $carMakeRepo->create(['make' => $row[1]]);
            }

            if ($row['2'] && isset($newCarMake->id)) {
                $newCarModel = $carModelRepo->create([
                    "car_make_id" => $newCarMake->id,
                    "model" => $row[2]
                ]);

                if (isset($newCarMake->id) && isset($newCarModel->id)) {
                    try {
                        $carRepo->create([
                            'id' => $row[0],
                            'car_make_id' => $newCarMake->id,
                            'car_model_id' => $newCarModel->id,
                            'year' => $row[3],
                            'variant' => $row[4]
                        ]);
                    } catch (\Exception $exception) {
                        echo $exception->getMessage();
                        continue;
                    }
                }
            }
        }

        fclose($handle);
    }
}
