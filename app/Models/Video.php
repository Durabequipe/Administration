<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'path',
        'thumbnail',
        'position_id',
        'is_main',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function interacts()
    {
        return $this->hasMany(Interact::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function interactWiths()
    {
        return $this->hasMany(Interact::class, 'link_to');
    }
}
