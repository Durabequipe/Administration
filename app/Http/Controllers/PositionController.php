<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PositionStoreRequest;
use App\Http\Requests\PositionUpdateRequest;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Position::class);

        $search = $request->get('search', '');

        $positions = Position::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.positions.index', compact('positions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Position::class);

        return view('app.positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Position::class);

        $validated = $request->validated();

        $position = Position::create($validated);

        return redirect()
            ->route('positions.edit', $position)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Position $position): View
    {
        $this->authorize('view', $position);

        return view('app.positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Position $position): View
    {
        $this->authorize('update', $position);

        return view('app.positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PositionUpdateRequest $request,
        Position $position
    ): RedirectResponse {
        $this->authorize('update', $position);

        $validated = $request->validated();

        $position->update($validated);

        return redirect()
            ->route('positions.edit', $position)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Position $position
    ): RedirectResponse {
        $this->authorize('delete', $position);

        $position->delete();

        return redirect()
            ->route('positions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
