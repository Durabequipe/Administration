<?php

namespace App\Http\Controllers\Api;

use App\Models\Interaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\InteractionResource;
use App\Http\Resources\InteractionCollection;
use App\Http\Requests\InteractionStoreRequest;
use App\Http\Requests\InteractionUpdateRequest;

class InteractionController extends Controller
{
    public function index(Request $request): InteractionCollection
    {
        $this->authorize('view-any', Interaction::class);

        $search = $request->get('search', '');

        $interactions = Interaction::search($search)
            ->latest()
            ->paginate();

        return new InteractionCollection($interactions);
    }

    public function store(InteractionStoreRequest $request): InteractionResource
    {
        $this->authorize('create', Interaction::class);

        $validated = $request->validated();

        $interaction = Interaction::create($validated);

        return new InteractionResource($interaction);
    }

    public function show(
        Request $request,
        Interaction $interaction
    ): InteractionResource {
        $this->authorize('view', $interaction);

        return new InteractionResource($interaction);
    }

    public function update(
        InteractionUpdateRequest $request,
        Interaction $interaction
    ): InteractionResource {
        $this->authorize('update', $interaction);

        $validated = $request->validated();

        $interaction->update($validated);

        return new InteractionResource($interaction);
    }

    public function destroy(
        Request $request,
        Interaction $interaction
    ): Response {
        $this->authorize('delete', $interaction);

        $interaction->delete();

        return response()->noContent();
    }
}
