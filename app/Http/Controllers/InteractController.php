<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Interact;
use App\Models\Position;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\InteractStoreRequest;
use App\Http\Requests\InteractUpdateRequest;

class InteractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Interact::class);

        $search = $request->get('search', '');

        $interacts = Interact::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.interacts.index', compact('interacts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Interact::class);

        $videos = Video::pluck('path', 'id');
        $positions = Position::pluck('type', 'id');

        return view(
            'app.interacts.create',
            compact('videos', 'videos', 'positions')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InteractStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Interact::class);

        $validated = $request->validated();

        $interact = Interact::create($validated);

        return redirect()
            ->route('interacts.edit', $interact)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Interact $interact): View
    {
        $this->authorize('view', $interact);

        return view('app.interacts.show', compact('interact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Interact $interact): View
    {
        $this->authorize('update', $interact);

        $videos = Video::pluck('path', 'id');
        $positions = Position::pluck('type', 'id');

        return view(
            'app.interacts.edit',
            compact('interact', 'videos', 'videos', 'positions')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        InteractUpdateRequest $request,
        Interact $interact
    ): RedirectResponse {
        $this->authorize('update', $interact);

        $validated = $request->validated();

        $interact->update($validated);

        return redirect()
            ->route('interacts.edit', $interact)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Interact $interact
    ): RedirectResponse {
        $this->authorize('delete', $interact);

        $interact->delete();

        return redirect()
            ->route('interacts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
