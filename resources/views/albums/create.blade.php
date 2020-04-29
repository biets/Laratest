@extends('templates.layout')
@section('content')

    <h1>Create</h1>
    @include('components.inputerrors')
    <form action="{{route('albums.save')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group">
            <label for="">Name</label>
            <input required type="text" name="name" id="name" class="form-control" value="{{old('name')}}" placeholder="Album name" />
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea required name="description" id="description">{{old('description')}}</textarea>
        </div>

        @include('albums.partials.fileupload')

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
