<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Project;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return new PlayerResource($project);
    }
}
