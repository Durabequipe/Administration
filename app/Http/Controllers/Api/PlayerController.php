<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Project;

class PlayerController extends Controller
{

    public function index()
    {
        return PlayerResource::collection(auth()->user()->projects)->collection;
    }

    public function show(Project $project)
    {
        return new PlayerResource($project);
    }
}
