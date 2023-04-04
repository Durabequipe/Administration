<?php

namespace App\Http\Controllers;

use App\Models\Project;

class BuilderController extends Controller
{
    public function index(Project $project)
    {
        return view('builder', compact('project'));
    }
}
