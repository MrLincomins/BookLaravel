<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surrender extends Model
{
    use HasFactory;

    protected $fillable = [
        'iduser',
        'idbook',
        'date'
    ];
}
