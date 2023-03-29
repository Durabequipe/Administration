<?php

namespace App\Http\Controllers\Api;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InteractResource;
use App\Http\Resources\InteractCollection;

class VideoInteractsController extends Controller
{
    public function index(Request $request, Video $video): InteractCollection
    {
        $this->authorize('view', $video);

        $search = $request->get('search', '');

        $interacts = $video
            ->adjacents()
            ->search($search)
            ->latest()
            ->paginate();

        return new InteractCollection($interacts);
    }

    public function store(Request $request, Video $video): InteractResource
    {
        $this->authorize('create', Interact::class);

        $validated = $request->validate([
            'content' => ['required', 'max:255', 'string'],
        ]);

        $interact = $video->adjacents()->create($validated);

        return new InteractResource($interact);
    }
}
