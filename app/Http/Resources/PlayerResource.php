<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'entrypointId' => $this->mainVideo?->id,
            'coverImage' => 'https://picsum.photos/1920/1080',
            'thumbnailImage' => 'https://picsum.photos/1920/1080',
            'videos' => $this->videos->map(fn(Video $video) => [
                "id" => $video->id,
                'name' => $video->name,
                "paths" => [
                    $video->desktop_path,
                    $video->mobile_path
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
