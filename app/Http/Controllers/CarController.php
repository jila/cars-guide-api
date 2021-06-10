<?php

namespace App\Http\Controllers;

use App\Contracts\CarRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CarController
 * @package App\Http\Controllers
 */
class CarController extends Controller
{
    /**
     * @param CarRepositoryInterface $carRepository
     * @param Request                $request
     * @return JsonResponse
     */
    public function addCar(CarRepositoryInterface $carRepository, Request $request): JsonResponse
    {
        $attributes = [
            'id' => $request->input('id'),
            'car_make_id' => $request->input('make_id'),
            'car_model_id' => $request->input('model_id'),
            'year' => $request->input('year'),
            'variant' => $request->input('variant'),
        ];

        if (is_null($attributes['car_make_id'])) {
            return response()->json([
                    'result' => 'error',
                    'message' => 'make_id is empty'
                ], 400
            );
        }

        if (is_null($attributes['car_model_id'])) {
            return response()->json([
                    'result' => 'error',
                    'message' => 'model_id is empty'
                ], 400
            );
        }

        try {
            $newCar = $carRepository->create($attributes);
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
            'new_car' => $newCar
        ]);
    }

    /**
     * @param CarRepositoryInterface $carRepository
     * @param Request                $request
     * @return JsonResponse
     */
    public function getCars(CarRepositoryInterface $carRepository, Request $request): JsonResponse
    {
        //TODO: use cache
        $attributes = [
            'key' => $request->input('key'),
            'id' => $request->input('id'),
            'car_make_id' => $request->input('make_id'),
            'car_model_id' => $request->input('model_id'),
            'year' => $request->input('year'),
            'variant' => $request->input('variant'),
        ];
        $pagination = [
            'limit' => $request->input('per_page', 10),
            'page'  => $request->input('page', 1)
        ];

        $cars = $carRepository->findCars($attributes, $pagination);
        return response()->json($cars);
    }

    /**
     * @param CarRepositoryInterface $carRepository
     * @param Request                $request
     * @param                        $key
     * @return JsonResponse
     */
    public function editCar(CarRepositoryInterface $carRepository, Request $request, $key): JsonResponse
    {
        $attributes = [
            'id' => $request->input('id'),
            'car_make_id' => $request->input('make_id'),
            'car_model_id' => $request->input('model_id'),
            'year' => $request->input('year'),
            'variant' => $request->input('variant'),
        ];

        try {
            $carRepository->update($attributes, ['key' => $key]);
        } catch (\Exception $exception) {
            return response()->json([
                    'result' => 'error',
                    'message' => $exception->getMessage()
                ]
            );
        }

        return response()->json([
                'result' => 'success',
                'message' => 'Successfully updated'
            ]
        );
    }

    public function deleteCar(CarRepositoryInterface $carRepository, Request $request, $key): JsonResponse
    {
        try {
            $carRepository->delete(['key' => $key]);
        } catch (\Exception $exception) {
            return response()->json([
                    'result' => 'error',
                    'message' => $exception->getMessage()
                ]
            );
        }

        return response()->json([
                'result' => 'success',
                'message' => 'Successfully updated'
            ]
        );
    }
}
