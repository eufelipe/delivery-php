<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client',
        'delivery_date',
        'target_start',
        'target_end',
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    protected $dates =[
        'target_start',
        'target_end',
    ];

}
