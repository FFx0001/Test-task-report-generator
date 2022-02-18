<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldCar extends Model
{
    use Uuids;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'vin',
        'engine_capacity',
        'engine_power',
        'type_of_kpp',
        'year_of_release',
        'date_of_sale',
        'dealer',
    ];
}
