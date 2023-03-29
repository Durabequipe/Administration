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
        'desktop_path',
        'mobile_path',
        'desktop_thumbnail',
        'mobile_thumbnail',
        'is_main',
        'interaction_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function interaction()
    {
        return $this->belongsTo(Interaction::class);
    }

    public function adjacents()
    {
        return $this->belongsToMany(Video::class, 'adjacents_videos', 'video_id', 'adjacent_id')->withPivot('content');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'adjacents_videos');
    }
}
