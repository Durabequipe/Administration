<?php

namespace App\Http\Controllers;

use App\Models\Project;

class BuilderController extends Controller
{

    public function index()
    {
        $projects = auth()->user()->projects;

        return view('builder.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('builder.show', compact('project'));
    }

    public function create()
    {
        return view('builder.create');
    }

    public function edit(Project $project)
    {
        return view('builder.edit', compact('project'));
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('builder.index');
    }


}
