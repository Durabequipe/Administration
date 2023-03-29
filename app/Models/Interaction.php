<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interaction extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['delay', 'position'];

    protected $searchableFields = ['*'];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
