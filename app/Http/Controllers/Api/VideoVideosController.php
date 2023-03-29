<?php
namespace App\Http\Controllers\Api;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoCollection;

class VideoVideosController extends Controller
{
    public function index(Request $request, Video $video): VideoCollection
    {
        $this->authorize('view', $video);

        $search = $request->get('search', '');

        $videos = $video
            ->videos()
            ->search($search)
            ->latest()
            ->paginate();

        return new VideoCollection($videos);
    }

    public function store(
        Request $request,
        Video $video,
        Video $adjacent
    ): Response {
        $this->authorize('update', $video);

        $video->videos()->syncWithoutDetaching([$video->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Video $video,
        Video $adjacent
    ): Response {
        $this->authorize('update', $video);

        $video->videos()->detach($video);

        return response()->noContent();
    }
}
