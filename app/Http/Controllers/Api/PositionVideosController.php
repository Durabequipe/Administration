<?php

namespace App\Http\Controllers\Api;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Http\Resources\VideoCollection;

class PositionVideosController extends Controller
{
    public function index(Request $request, Position $position): VideoCollection
    {
        $this->authorize('view', $position);

        $search = $request->get('search', '');

        $videos = $position
            ->videos()
            ->search($search)
            ->latest()
            ->paginate();

        return new VideoCollection($videos);
    }

    public function store(Request $request, Position $position): VideoResource
    {
        $this->authorize('create', Video::class);

        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'path' => ['required', 'max:255', 'string'],
            'thumbnail' => ['nullable', 'file'],
            'is_main' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('public');
        }

        $video = $position->videos()->create($validated);

        return new VideoResource($video);
    }
}
