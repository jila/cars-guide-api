<?php

namespace App\Http\Controllers;

use App\Contracts\CarRepositoryInterface;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CarController
 * @package App\Http\Controllers
 */
class CarController extends Controller
{
    use ValidatesRequests;

    /**
     * @param CarRepositoryInterface $carRepository
     * @param Request                $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addCar(CarRepositoryInterface $carRepository, Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'id' => ['required'],
                'year' => ['digits:4'],
                'make_id' => ['required'],
                'model_id' => ['required']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => 'error',
                'message' => $e->getMessage()
            ], 400
            );
        }

        $attributes = [
            'id' => $request->input('id'),
            'car_make_id' => $request->input('make_id'),
            'car_model_id' => $request->input('model_id'),
            'year' => $request->input('year'),
            'variant' => $request->input('variant'),
        ];

        try {
            $newCar = $carRepository->create($attributes);
        } catch (\Exception $exception) {
            return response()->json([
                    'result' => 'error',
                    'message' => $exception->getMessage()
                ], 500
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
            'page'  => $request->input('page', 1),
            'order_by' => $request->input('order_by')
        ];

        $cars = $carRepository->findCars($attributes, $pagination);
        return response()->json($cars);
    }

    /**
     * @param CarRepositoryInterface $carRepository
     * @param Request                $request
     * @param                        $id
     * @return JsonResponse
     */
    public function editCar(CarRepositoryInterface $carRepository, Request $request, $id): JsonResponse
    {
        try {
            $this->validate($request, [
                'year' => ['digits:4'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => 'error',
                'message' => $e->getMessage()
            ], 400
            );
        }

        $attributes = [
            'car_make_id' => $request->input('make_id'),
            'car_model_id' => $request->input('model_id'),
            'year' => $request->input('year'),
            'variant' => $request->input('variant')
        ];

        $attributes = array_filter($attributes);

        try {
            $carRepository->update($attributes, ['id' => $id]);
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

    public function deleteCar(CarRepositoryInterface $carRepository, $id): JsonResponse
    {
        if (!$id) {
            return response()->json([
                    'result' => 'error',
                    'message' => 'id is required'
                ]
            );
        }

        try {
            $carRepository->delete(['id' => $id]);
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
