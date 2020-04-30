@extends('templates.layout')
@section('content')

<h1>edit</h1>
@include('components.inputerrors')
<form action="/albums/{{$album->id}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PATCH" />
    @include('albums.partials.fileupload')

    <div class="form-group">
        <label for="">Name</label>
        <input required type="text" name="name" id="name" class="form-control" value="{{$album->album_name}}" placeholder="Album name" />
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" id="description">{{$album->description}}</textarea>
    </div>
    <button required type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('albums')}}" class=" btn btn-success">Back</a>
    <a href="{{route('albums.getImages', $album->id)}}" class=" btn btn-default">Images</a>
</form>
@endsection
