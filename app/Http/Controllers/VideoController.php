<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Project;
use App\Models\Position;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Video::class);

        $search = $request->get('search', '');

        $videos = Video::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.videos.index', compact('videos', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Video::class);

        $projects = Project::pluck('name', 'id');
        $positions = Position::pluck('type', 'id');

        return view('app.videos.create', compact('projects', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Video::class);

        $validated = $request->validated();
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('public');
        }

        $video = Video::create($validated);

        return redirect()
            ->route('videos.edit', $video)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Video $video): View
    {
        $this->authorize('view', $video);

        return view('app.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Video $video): View
    {
        $this->authorize('update', $video);

        $projects = Project::pluck('name', 'id');
        $positions = Position::pluck('type', 'id');

        return view(
            'app.videos.edit',
            compact('video', 'projects', 'positions')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        VideoUpdateRequest $request,
        Video $video
    ): RedirectResponse {
        $this->authorize('update', $video);

        $validated = $request->validated();
        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::delete($video->thumbnail);
            }

            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('public');
        }

        $video->update($validated);

        return redirect()
            ->route('videos.edit', $video)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Video $video): RedirectResponse
    {
        $this->authorize('delete', $video);

        if ($video->thumbnail) {
            Storage::delete($video->thumbnail);
        }

        $video->delete();

        return redirect()
            ->route('videos.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
