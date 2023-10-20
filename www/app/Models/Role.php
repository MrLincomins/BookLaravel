<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public mixed $permissions;

    protected $fillable = ['name', 'permissions'];

    protected $casts = [
        'permissions' => 'json',
    ];
}
