<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index(Request $request): ProjectCollection
    {
        $this->authorize('view-any', Project::class);

        $search = $request->get('search', '');

        $projects = auth()->user()->projects()->search($search)
            ->latest()
            ->paginate();

        return new ProjectCollection($projects);
    }

    public function store(ProjectStoreRequest $request): ProjectResource
    {
        $this->authorize('create', Project::class);

        $validated = $request->validated();

        $project = Project::create($validated);

        return new ProjectResource($project);
    }

    public function show(Request $request, Project $project): ProjectResource
    {
        $this->authorize('view', $project);

        return new ProjectResource($project);
    }

    public function update(
        ProjectUpdateRequest $request,
        Project $project
    ): ProjectResource {
        $this->authorize('update', $project);

        $validated = $request->validated();

        $project->update($validated);

        return new ProjectResource($project);
    }

    public function destroy(Request $request, Project $project): Response
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->noContent();
    }

    public function getProjectsIds(): JsonResponse
    {
        $ids = Project::pluck('id');

        return response()->json($ids);
    }
}
