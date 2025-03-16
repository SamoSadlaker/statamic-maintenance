@extends('statamic::layout')
@section('title', 'Maintenance settings')
@section('content')
    <publish-form
        title="Maintenance settings"
        action="{{ cp_route('samosadlaker.maintenance.update') }}"
        method="put"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@endsection
