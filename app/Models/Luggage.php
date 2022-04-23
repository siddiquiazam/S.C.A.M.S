<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Luggage extends Model
{
    use HasFactory;

    protected $table = 'Luggage';
}
