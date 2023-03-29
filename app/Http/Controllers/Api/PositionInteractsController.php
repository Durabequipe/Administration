<?php

namespace App\Http\Controllers\Api;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InteractResource;
use App\Http\Resources\InteractCollection;

class PositionInteractsController extends Controller
{
    public function index(
        Request $request,
        Position $position
    ): InteractCollection {
        $this->authorize('view', $position);

        $search = $request->get('search', '');

        $interacts = $position
            ->interacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new InteractCollection($interacts);
    }

    public function store(
        Request $request,
        Position $position
    ): InteractResource {
        $this->authorize('create', Interact::class);

        $validated = $request->validate([
            'video_id' => ['required', 'exists:videos,id'],
            'link_to' => ['required', 'exists:videos,id'],
            'content' => ['required', 'max:255', 'string'],
        ]);

        $interact = $position->interacts()->create($validated);

        return new InteractResource($interact);
    }
}
