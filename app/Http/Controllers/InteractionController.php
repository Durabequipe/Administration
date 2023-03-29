<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Interaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\InteractionStoreRequest;
use App\Http\Requests\InteractionUpdateRequest;

class InteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Interaction::class);

        $search = $request->get('search', '');

        $interactions = Interaction::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.interactions.index',
            compact('interactions', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Interaction::class);

        return view('app.interactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InteractionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Interaction::class);

        $validated = $request->validated();

        $interaction = Interaction::create($validated);

        return redirect()
            ->route('interactions.edit', $interaction)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Interaction $interaction): View
    {
        $this->authorize('view', $interaction);

        return view('app.interactions.show', compact('interaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Interaction $interaction): View
    {
        $this->authorize('update', $interaction);

        return view('app.interactions.edit', compact('interaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        InteractionUpdateRequest $request,
        Interaction $interaction
    ): RedirectResponse {
        $this->authorize('update', $interaction);

        $validated = $request->validated();

        $interaction->update($validated);

        return redirect()
            ->route('interactions.edit', $interaction)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Interaction $interaction
    ): RedirectResponse {
        $this->authorize('delete', $interaction);

        $interaction->delete();

        return redirect()
            ->route('interactions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
