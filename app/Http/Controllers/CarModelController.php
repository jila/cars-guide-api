<?php

namespace App\Http\Controllers;

use App\Contracts\CarMakeRepositoryInterface;
use App\Contracts\CarModelRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarModelController extends Controller
{
    /**
     * @param CarModelRepositoryInterface $carModel
     * @param Request                     $request
     * @return JsonResponse
     */
    public function addCarModel(CarModelRepositoryInterface $carModel, Request $request): JsonResponse
    {
        $attributes = [];
        $attributes['model'] = $request->input('model');
        $attributes['car_make_id'] = $request->input('make_id');

        if (is_null($attributes['car_make_id'])) {
            return response()->json([
                    'result' => 'error',
                    'message' => 'make_id is empty'
                ]
            );
        }

        try {
            $newCarModel = $carModel->create($attributes);
        } catch (\Exception $exception) {
            return response()->json([
                    'result' => 'error',
                    'message' => $exception->getMessage()
                ]
            );
        }

        return response()->json([
            'result' => 'success',
            'message' => 'Model creates successfully',
            'model_id' => $newCarModel->id
        ]);
    }

    public function getCarModel(CarModelRepositoryInterface $carModel, Request $request): JsonResponse
    {
        $attributes = [];
        $attributes['make'] = $request->input('make');
        $attributes['car_make_id'] = $request->input('make_id');

        $carModels = $carModel->getCarModels($attributes);

        // The request only needs to get model names. It is used by UI type ahead
        if (!is_null($request->input('beautify'))) {
            $result = [];
            foreach ($carModels as $carModel) {
                $result[$carModel['id']] = $carModel['model'];
                return response()->json($result);
            }
        }

        // return every thing. it can be used by the list of all the car models
        return response()->json([$carModels]);
    }
}
