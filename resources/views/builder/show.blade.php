@extends('layouts.main')

@section('scriptsHead')
    @vite(['resources/js/jsPlumb.js', 'resources/js/draggable.js'])
@endsection

@section('content')
    <div class="h-screen w-screen">
        <div class="fixed z-[11] top-10 left-10 shadow-2xl p-5 h-16 rounded-2xl flex justify-around items-center">
            <a class="cursor-pointer p-2 rounded mr-10" href="{{ route('builder.index') }}">
                <i class="fas fa-chevron-left mr-2"></i>Projets
            </a>
            <h1 class="font-bold">{{ $project->name }}</h1>
        </div>
        @livewire('board', ['project' => $project])

        <x-tall-interactive::modal
            id="set-content-link"
            :form="App\Forms\SetContentLinkForm::class"
            title="Texte de lien"
            dismissableWith="Fermer"
            submitWith="Sauvegarder"
            dismissable
        />

        <x-tall-interactive::modal
            id="video-form"
            :form="App\Forms\VideoForm::class"
            :project="$project"
            dismissableWith="Fermer"
            submitWith="Sauvegarder"
            dismissable
        />
    </div>

@endsection
