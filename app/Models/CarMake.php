<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarMake extends Model
{
    use HasFactory;

    protected $fillable = [
        'make'
    ];

    /**
     * @return HasMany
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'car_make_id');
    }

    /**
     * @return HasMany
     */
    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class, 'car_make_id');
    }
}
