<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'arname', 'ardescription', 'price', 'rate', 'quantity', 'version', 'time', 'store_id', 'img'
    ];
}
