<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Project;

class PlayerController extends Controller
{
    public function index(Project $project)
    {
        return new PlayerResource($project);
    }
}
