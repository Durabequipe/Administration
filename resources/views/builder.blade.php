@extends('layouts.main')

@section('content')
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

