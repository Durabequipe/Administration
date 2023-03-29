<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['x', 'y', 'zindex', 'type'];

    protected $searchableFields = ['*'];

    public function interacts()
    {
        return $this->hasMany(Interact::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
