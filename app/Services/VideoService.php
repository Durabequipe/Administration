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

    private function processThumbnailGeneration($videoPath, $thumbnailPath, $sec = 0): string
    {
        $video = $this->ffmpeg->open($videoPath);
        $frame = $video->frame(TimeCode::fromSeconds($sec));
        $frame->save($thumbnailPath);

        return basename($thumbnailPath);
    }

    public function generateThumbnailFromPath(string $videoPath): string
    {
        $path = storage_path('app/public/thumbnails/' . Str::uuid() . '.jpg');
        return $this->processThumbnailGeneration($videoPath, $path);
    }

    public function ensureNotRecursive(Video $video1, Video $video2): bool
    {

        $ids = $this->getAllAdjacentIds($video2);

        return !in_array($video1->id, $ids);

    }

    public function getAllAdjacentIds(Video $video, $ids = []): array
    {
        $ids[] = $video->id;
        foreach ($video->adjacents as $adjacent) {
            $ids = $this->getAllAdjacentIds($adjacent, $ids);
        }

        return $ids;
    }

    public function getAllParents(Video $video, $videos = []): array
    {
        $videos[] = $video;
        foreach ($video->parents as $parent) {
            $videos = $this->getAllParents($parent, $videos);
        }

        return $videos;
    }

    public function getThemeVideo(Video $video): ?Video
    {
        $videos = collect($this->getAllParents($video));

        $videos = $videos->reverse();

        //find the index where the video can choose a theme
        $index = $videos->search(fn(Video $video) => $video->can_choose_theme);

        //remove all videos before the index
        $videos = $videos->slice($index);

        $videos = $videos->reject(fn(Video $video) => $video->can_choose_theme);

        return $videos->first();
    }
}
