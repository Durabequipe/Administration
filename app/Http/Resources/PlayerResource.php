<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'entrypointId' => $this->mainVideo->id,
            'videos' => $this->videos->map(fn(Video $video) => [
                "id" => $video->id,
                "paths" => [
                    $video->desktop_path,
                    $video->mobile_path
                ],
                "interactionPosition" => "FULL",
                "popupDuration" => 5,
                "text" => "Quel est le nom de ce personnage ?",
                "interactions" => $video->adjacents->map(fn($adjacent) => [
                    "id" => $adjacent->id,
                    "content" => $adjacent->pivot->content,
                ]),
            ])
        ];
    }
}
