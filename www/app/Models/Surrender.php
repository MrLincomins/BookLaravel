<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surrender extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'iduser',
        'idbook',
        'date',
        'unique_key'
    ];
}
