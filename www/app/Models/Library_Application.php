<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library_Application extends Model
{
    use HasFactory;

    protected $table = 'library_applications';

    protected $fillable = [
        'unique_key',
        'idUser',
        'nameUser',
    ];
}
