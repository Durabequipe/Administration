@extends('layouts.main')

@section('content')
    @include('includes.layouts.navigation')

    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold">Modifer un projet</h1>

        <x-tall-interactive::inline-form
            :form="App\Forms\ProjectForm::class"
            :project="$project"
        ></x-tall-interactive::inline-form>

    </div>
@endsection
