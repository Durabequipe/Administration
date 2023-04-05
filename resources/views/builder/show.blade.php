@extends('layouts.main')

@section('content')
    <div class="fixed z-[999] top-10 left-10 shadow-2xl p-5 h-16 rounded-2xl flex justify-around items-center">
        <a class="cursor-pointer p-2 rounded mr-10" href="{{ route('builder.index') }}">
            <i class="fas fa-chevron-left mr-2"></i>Projets
        </a>
        <h1 class="font-bold">{{ $project->name }}</h1>
    </div>
    @livewire('board', ['project' => $project])
    <x-tall-interactive::modal
        id="set-content-link"
        :form="App\Forms\SetContentLinkForm::class"
    />

    <x-tall-interactive::modal
        id="video-form"
        :form="App\Forms\VideoForm::class"
        :project="$project"
        dismissable
    />

@endsection

