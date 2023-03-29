<?php

namespace App\Http\Controllers\Api;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Http\Resources\PositionCollection;
use App\Http\Requests\PositionStoreRequest;
use App\Http\Requests\PositionUpdateRequest;

class PositionController extends Controller
{
    public function index(Request $request): PositionCollection
    {
        $this->authorize('view-any', Position::class);

        $search = $request->get('search', '');

        $positions = Position::search($search)
            ->latest()
            ->paginate();

        return new PositionCollection($positions);
    }

    public function store(PositionStoreRequest $request): PositionResource
    {
        $this->authorize('create', Position::class);

        $validated = $request->validated();

        $position = Position::create($validated);

        return new PositionResource($position);
    }

    public function show(Request $request, Position $position): PositionResource
    {
        $this->authorize('view', $position);

        return new PositionResource($position);
    }

    public function update(
        PositionUpdateRequest $request,
        Position $position
    ): PositionResource {
        $this->authorize('update', $position);

        $validated = $request->validated();

        $position->update($validated);

        return new PositionResource($position);
    }

    public function destroy(Request $request, Position $position): Response
    {
        $this->authorize('delete', $position);

        $position->delete();

        return response()->noContent();
    }
}
