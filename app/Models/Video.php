<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use App\Services\VideoService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'name',
        'desktop_path',
        'mobile_path',
        'desktop_thumbnail',
        'mobile_thumbnail',
        'is_main',
        'interaction_id',
        'interaction_title',
        'position_x',
        'position_y',
        'can_choose_theme'
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

    public function parents()
    {
        return $this->belongsToMany(Video::class, 'adjacents_videos', 'adjacent_id', 'video_id')->withPivot('content');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'adjacents_videos');
    }

    public function desktopPath(): Attribute
    {
        return Attribute::make(
            get: fn() => url(Storage::disk('videos')->url($this->attributes['desktop_path'])),
            set: fn($value) => $this->attributes['desktop_path'] = $value
        );
    }

    public function mobilePath(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->attributes['mobile_path'] ? url(Storage::disk('videos')->url($this->attributes['mobile_path'])) : null,
            set: fn($value) => $this->attributes['mobile_path'] = $value
        );
    }

    public function desktopThumbnail(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->attributes['desktop_thumbnail'] ? url(Storage::disk('thumbnails')->url($this->attributes['desktop_thumbnail'])) : null,
            set: fn($value) => $this->attributes['desktop_thumbnail'] = $value
        );
    }

    public function generateThumbnails()
    {
        $this->generateDesktopThumbnail();
        $this->generateMobileThumbnail();
    }

    public function generateDesktopThumbnail()
    {
        if ($this->desktop_thumbnail) return;
        $this->update([
            'desktop_thumbnail' => app(VideoService::class)->generateThumbnailFromPath($this->desktop_path),
        ]);
    }

    public function generateMobileThumbnail()
    {
        if ($this->mobile_thumbnail || !$this->mobile_path) return;
        $this->update([
            'desktop_thumbnail' => app(VideoService::class)->generateThumbnailFromPath($this->mobile_path),
        ]);
    }

    public function getThemeVideoAttribute(): ?Video
    {
        return (new VideoService)->getThemeVideo($this);
    }
}
