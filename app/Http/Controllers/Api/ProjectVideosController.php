<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoResource;
use App\Models\Project;
use App\Models\Video;
use Illuminate\Http\Request;

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
            'desktop_path' => ['required', 'max:255', 'string'],
            'desktop_thumbnail' => ['image', 'max:1024', 'nullable'],
            'is_main' => ['nullable', 'boolean'],
            'name' => ['required', 'max:255', 'string'],
            'mobile_path' => ['required', 'max:255', 'string'],
            'mobile_thumbnail' => ['image', 'max:1024', 'nullable'],
            'interaction_id' => ['required', 'exists:interactions,id'],

        ]);

        if ($request->hasFile('desktop_thumbnail')) {
            $validated['desktop_thumbnail'] = $request
                ->file('desktop_thumbnail')
                ->store('public');
        }

        $video = $project->videos()->create($validated);

        return new VideoResource($video);
    }
}
