<?php

namespace App\Services;

use App\Models\Video;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Support\Str;

class VideoService
{
    private $ffmpeg;

    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => config('app.ffmpeg_bin') . '/ffmpeg',
            'ffprobe.binaries' => config('app.ffmpeg_bin') . '/ffprobe',
        ]);

    }

    public function generateThumbnail(Video $video)
    {
        $thumbnail = storage_path('app/public/thumbnails/' . $video->id . '.jpg');
        return $this->processThumbnailGeneration($video->desktop_path, $thumbnail);
    }

    private function processThumbnailGeneration($videoPath, $thumbnailPath, $sec = 10): string
    {
        $video = $this->ffmpeg->open($videoPath);
        $frame = $video->frame(TimeCode::fromSeconds($sec));
        $frame->save($thumbnailPath);

        return $thumbnailPath;
    }

    public function generateThumbnailFromPath(string $videoPath): string
    {
        $path = storage_path('app/public/thumbnails/' . Str::uuid() . '.jpg');
        return $this->processThumbnailGeneration($videoPath, $path);
    }
}
