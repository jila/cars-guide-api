<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    protected $primaryKey = 'key';

    protected $fillable = [
        'id',
        'car_make_id',
        'car_model_id',
        'year',
        'variant'
    ];

    /**
     * Get the CarMake that owns the car.
     * @return BelongsTo
     */
    public function carMake(): BelongsTo
    {
        return $this->belongsTo(CarMake::class, 'car_make_id');
    }

    /**
     * Get the CarModel that owns the car.
     * @return BelongsTo
     */
    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }
}
