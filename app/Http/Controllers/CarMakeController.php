<?php

namespace App\Http\Controllers;

use App\Contracts\CarMakeRepositoryInterface;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class CarMakeController extends Controller
{
    /**
     * This method will create a new carMake
     * record in the database and return the newly created record id
     * or it will return error
     * @param CarMakeRepositoryInterface $carMake
     * @param Request                    $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCarMake(CarMakeRepositoryInterface $carMake, Request $request): JsonResponse
    {
        $attributes = [];
        $attributes['make'] = $request->input('make');

        try {
            $newCarMake = $carMake->create($attributes);
        } catch (\Exception $exception) {
            return response()->json([
                'result' => 'error',
                'message' => $exception->getMessage()
                ]
            );
        }

        return response()->json([
            'result' => 'success',
            'message' => 'Make creates successfully',
            'make_id' => $newCarMake->id
        ]);
    }

    /**
     * this method being called by the UI typeahead to fill the make input in the create car form
     * if the flag beatify is not set in the request it would return all columns
     *
     * @param CarMakeRepositoryInterface $carMake
     * @param Request                    $request
     * @return JsonResponse
     */
    public function getCarMakes(CarMakeRepositoryInterface $carMake, Request $request): JsonResponse
    {
        $attributes = [];
        $attributes['make'] = $request->input('make');

        $carMakes = $carMake->getCarMakes($attributes);

        // The request only needs make names. It is used by UI type ahead
        if (!is_null($request->input('beatify'))) {
            $result = [];
            foreach ($carMakes as $carMake) {
                $result[$carMake['id']] = $carMake['make'];
                return response()->json($result);
            }
        }

        // return every thing. it can be used by the list of all the car makes
        return response()->json([$carMakes]);
    }
}
