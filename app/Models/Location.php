<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Location extends Model
{
    use HasFactory;

     protected $fillable = [
        'loc_name',
        'code',
        'latitude',
        'longitude',
        'start_date',
        'end_date',
        'is_delete',        
    ];

    protected $casts = [
	    'latitude' => 'float',
	    'longitude' => 'float',
	    'start_date' => 'date',
	    'end_date' => 'date',
	    'is_delete' => 'boolean',
	];

    

}
