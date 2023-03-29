<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interact extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['video_id', 'link_to', 'content', 'position_id'];

    protected $searchableFields = ['*'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function interactWith()
    {
        return $this->belongsTo(Video::class, 'link_to');
    }
}
