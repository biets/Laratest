@extends('templates.layout')
@section('content')

<h1>edit</h1>

<form action="/albums/{{$album->id}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PATCH" />
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
