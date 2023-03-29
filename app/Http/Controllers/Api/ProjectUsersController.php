<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class ProjectUsersController extends Controller
{
    public function index(Request $request, Project $project): UserCollection
    {
        $this->authorize('view', $project);

        $search = $request->get('search', '');

        $users = $project
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(
        Request $request,
        Project $project,
        User $user
    ): Response {
        $this->authorize('update', $project);

        $project->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Project $project,
        User $user
    ): Response {
        $this->authorize('update', $project);

        $project->users()->detach($user);

        return response()->noContent();
    }
}
