<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Http\Resources\VideoCollection;

class ProjectVideosController extends Controller
{
    public function index(Request $request, Project $project): VideoCollection
    {
        $this->authorize('view', $project);

        $search = $request->get('search', '');

        $videos = $project
            ->videos()
            ->search($search)
            ->latest()
            ->paginate();

        return new VideoCollection($videos);
    }

    public function store(Request $request, Project $project): VideoResource
    {
        $this->authorize('create', Video::class);

        $validated = $request->validate([
            'path' => ['required', 'max:255', 'string'],
            'thumbnail' => ['nullable', 'file'],
            'position_id' => ['required', 'exists:positions,id'],
            'is_main' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('public');
        }

        $video = $project->videos()->create($validated);

        return new VideoResource($video);
    }
}
