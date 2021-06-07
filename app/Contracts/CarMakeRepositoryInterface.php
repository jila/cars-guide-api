<?php
namespace App\Contracts;

interface CarMakeRepositoryInterface
{
    public function getCarMakes(string $carMake): array;
}
