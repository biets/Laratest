@extends('templates.layout')
@section('title', 'Blog')
@section('content')
    <h1>Blog</h1>

    @component('components.card',
    [
        'img_title'=>'Image title',
        'img_url'=> 'https://picsum.photos/seed/picsum/200/300'
    ]

    )
    <p>Ciao prova</p>
    @endcomponent
@endsection
@section('footer')
    @parent

@stop
