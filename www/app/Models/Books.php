<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [
        'tittle',
        'author',
        'year',
        'isbn',
        'count',
        'genre',
        'picture',
        'library_id'
    ];


    public function library(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Library::class, 'library_id');
    }
}
