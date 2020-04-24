@extends('templates.layout')
@section('title', $title)
@section('content')
<h1>{{$title}} B</h1>

    @component('component')


@endsection
@section('footer')
    @parent
    <script>
        alert('footer');
    </script>
    @stop
