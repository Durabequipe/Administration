<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'description'];

    protected $searchableFields = ['*'];

    public function videos() : HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function mainVideo() : HasOne
    {
        return $this->videos()->one()->where('is_main', true) ?? $this->videos()->one();
    }
}
