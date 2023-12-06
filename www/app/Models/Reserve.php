<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Reserve extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'iduser',
        'idbook',
        'date',
        'unique_key'
    ];
}
