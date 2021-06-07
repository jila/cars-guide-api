<?php
namespace App\Contracts;

interface CarMakeRepositoryInterface
{
    public function getCarMakes(array $attributes): array;
}
