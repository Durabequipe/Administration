<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PlayerResource extends JsonResource
{

    public static $wrap = null;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'isActive' => (boolean)$this->is_active,
            'entrypointId' => $this->mainVideo?->id,
            'coverImage' => Storage::disk('images')->url($this->cover_image),
            'thumbnailImage' => Storage::disk('images')->url($this->thumbnail_image),
            'videos' => $this->videos->map(fn(Video $video) => [
                "id" => $video->id,
                'name' => $video->name,
                'canChooseTheme' => (boolean)$video->can_choose_theme,
                "paths" => [
                    $video->desktop_path,
                    $video->mobile_path
                ],
                'thumbnails' => [
                    $video->desktop_thumbnail,
                    $video->mobile_thumbnail
                ],
                "animation" => [
                    "title" => $video->interaction_title,
                    "position" => $video->interaction->position,
                    "duration" => $video->interaction->delay,
                ],
                "interactions" => $video->adjacents->map(fn($adjacent) => [
                    "id" => $adjacent->id,
                    "content" => $adjacent->pivot->content,
                ]),
            ])
        ];
    }
}
