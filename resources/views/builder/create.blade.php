@extends('layouts.main')

@section('content')
    @include('includes.layouts.navigation')

    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold">Créer un projet</h1>

        <x-tall-interactive::inline-form
            :form="App\Forms\ProjectForm::class"
        ></x-tall-interactive::inline-form>

    </div>
@endsection
