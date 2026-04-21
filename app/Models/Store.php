<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'arname',
        'location',
        'arlocation',
        'description',
        'ardescription',
        'rate',
        'img',
        'storehead_id'
    ];


}
