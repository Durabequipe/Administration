<?php

namespace App\Http\Controllers\Api;

use App\Models\Interact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\InteractResource;
use App\Http\Resources\InteractCollection;
use App\Http\Requests\InteractStoreRequest;
use App\Http\Requests\InteractUpdateRequest;

class InteractController extends Controller
{
    public function index(Request $request): InteractCollection
    {
        $this->authorize('view-any', Interact::class);

        $search = $request->get('search', '');

        $interacts = Interact::search($search)
            ->latest()
            ->paginate();

        return new InteractCollection($interacts);
    }

    public function store(InteractStoreRequest $request): InteractResource
    {
        $this->authorize('create', Interact::class);

        $validated = $request->validated();

        $interact = Interact::create($validated);

        return new InteractResource($interact);
    }

    public function show(Request $request, Interact $interact): InteractResource
    {
        $this->authorize('view', $interact);

        return new InteractResource($interact);
    }

    public function update(
        InteractUpdateRequest $request,
        Interact $interact
    ): InteractResource {
        $this->authorize('update', $interact);

        $validated = $request->validated();

        $interact->update($validated);

        return new InteractResource($interact);
    }

    public function destroy(Request $request, Interact $interact): Response
    {
        $this->authorize('delete', $interact);

        $interact->delete();

        return response()->noContent();
    }
}
