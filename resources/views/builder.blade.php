@extends('layouts.main')

@section('content')
    @livewire('board', ['project' => $project])
@endsection

