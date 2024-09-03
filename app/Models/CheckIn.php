<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'loc_id',
        'date',
        'user_name',
        'loc_name',
        'loc_latlong',
        'check_in_time',
        'check_in_latlong',
        'check_in_distance',
        'check_out_time',
        'check_out_latlong',
        'check_out_distance',
        'is_delete',
    ];


    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'check_in_distance' => 'float',
        'check_out_distance' => 'float',
        'is_delete' => 'boolean',
    ];


}