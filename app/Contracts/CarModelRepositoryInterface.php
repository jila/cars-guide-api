<?php
namespace App\Contracts;

interface CarModelRepositoryInterface
{
    public function getCarModels(array $attributes): array;
}
