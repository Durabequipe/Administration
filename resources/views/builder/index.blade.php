@extends('layouts.main')

@section('content')
    @include('includes.layouts.navigation')

    <div class="grid grid-cols-4 p-10 gap-2">
        @foreach($projects as $project)
            @include('includes.Builder.ProjectCard', ['project' => $project])
        @endforeach


        <a href="{{ route('builder.create') }}">
            <div class="col-span-1 border-2 h-96 rounded flex justify-center items-center">
                <i class="fas fa-plus-circle text-5xl"></i>
            </div>
        </a>
    </div>

@endsection
