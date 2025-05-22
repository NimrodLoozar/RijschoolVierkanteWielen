<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    /** @use HasFactory<\Database\Factories\AutoFactory> */
    use HasFactory;

    protected $fillable = ['brand', 'model', 'license_plate', 'fuel', 'is_active', 'note', 'photo'];
}
