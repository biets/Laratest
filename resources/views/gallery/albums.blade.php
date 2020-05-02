@extends('templates.layout')
@section('content')

    <div class="row row-cols-1 row-cols-md-3">

    @foreach($albums as $album)
            <div class="col mb-4">
            <div class="card h-100">

                <a href="{{route('gallery.album.images',$album)}}">
                    <img lass="card-img-top" src="{{asset($album->path)}}" class="card-img-top" />
                </a>
            <div class="card-body">
                <h4><a href="{{route('gallery.album.images',$album)}}">{{$album->album_name}}</a></h4>
                <p>
                    @foreach($album->categories as $cat)
                        <a href="{{route('gallery.albums.category', $cat->id)}}">{{$cat->category_name}}</a> /
                    @endforeach
                </p>
                <p class="card-text">{{$album->description}}</p>
            </div>
            <div class="card-footer">
            <p class="card-text"><small calss="text-muted">{{$album->created_at->diffForHumans()}}</small></p>
            </div>
        </div>
            </div>
    @endforeach

    </div>
@endsection
