<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereIn(string $string, \Illuminate\Support\Collection $pluck)
 */
class Books extends Model
{
    use HasFactory;
    use Auditable;

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
