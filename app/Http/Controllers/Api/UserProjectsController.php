<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectCollection;

class UserProjectsController extends Controller
{
    public function index(Request $request, User $user): ProjectCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $projects = $user
            ->projects()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProjectCollection($projects);
    }

    public function store(
        Request $request,
        User $user,
        Project $project
    ): Response {
        $this->authorize('update', $user);

        $user->projects()->syncWithoutDetaching([$project->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        User $user,
        Project $project
    ): Response {
        $this->authorize('update', $user);

        $user->projects()->detach($project);

        return response()->noContent();
    }
}
