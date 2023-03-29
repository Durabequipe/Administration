<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoResource;
use App\Models\Interaction;
use App\Models\Video;
use Illuminate\Http\Request;

class InteractionVideosController extends Controller
{
    public function index(
        Request $request,
        Interaction $interaction
    ): VideoCollection {
        $this->authorize('view', $interaction);

        $search = $request->get('search', '');

        $videos = $interaction
            ->videos()
            ->search($search)
            ->latest()
            ->paginate();

        return new VideoCollection($videos);
    }

    public function store(
        Request $request,
        Interaction $interaction
    ): VideoResource {
        $this->authorize('create', Video::class);

        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'desktop_path' => ['required', 'max:255', 'string'],
            'desktop_thumbnail' => ['image', 'max:1024', 'nullable'],
            'is_main' => ['nullable', 'boolean'],
            'name' => ['required', 'max:255', 'string'],
            'mobile_path' => ['required', 'max:255', 'string'],
            'mobile_thumbnail' => ['image', 'max:1024', 'nullable'],
        ]);

        if ($request->hasFile('desktop_thumbnail')) {
            $validated['desktop_thumbnail'] = $request
                ->file('desktop_thumbnail')
                ->store('public');
        }

        $video = $interaction->videos()->create($validated);

        return new VideoResource($video);
    }
}
