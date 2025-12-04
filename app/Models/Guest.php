<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['name', 'amount', 'guests_count', 'image_path', 'description'];
}