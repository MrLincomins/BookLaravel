<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    use Auditable;

    protected $fillable = ['name', 'permissions', 'unique_key'];

    protected $casts = [
        'permissions' => 'json',
    ];
}
