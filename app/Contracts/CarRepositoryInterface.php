<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CarRepositoryInterface
{
    public function findCars(array $attributes = [], array $pagination = []): array;
}
