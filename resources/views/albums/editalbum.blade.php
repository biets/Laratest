@extends('templates.layout')
@section('content')

<h1>edit</h1>

<form action="/albums/{{$album->id}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PATCH" />
    @if($album->album_thumb)
        <div class="form-group">
            <img src="{{$album->album_thumb}}" title="{{$album->album_name}}" alt="{{$album->album_name}}" />
        </div>
    @endif
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{$album->album_name}}" placeholder="Album name" />
    </div>
    <div class="form-group">
        <label for="">Thumbnail</label>
        <input type="file" name="album_thumb" id="album_thumb" class="form-control" value="{{$album->album_thumb}}" placeholder="Album thumb" />
    </div>
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{$album->album_name}}" placeholder="Album name" />
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" id="description">{{$album->description}}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
