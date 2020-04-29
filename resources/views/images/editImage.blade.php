@extends('templates.layout')
@section('content')

    <h1>
    @if($photo->id)
        Edit photo
        @else
        New Image
        @endif
    </h1>
    @include('components.inputerrors')
    @if($photo->id)
    <form action="{{route('photos.update', $photo->id)}}" method="POST" enctype="multipart/form-data">
        {{method_field('PATCH')}}
        @else
            <form action="{{route('photos.store')}}" method="POST" enctype="multipart/form-data">

            @endif

                {{csrf_field()}}
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{old('name', $photo->name)}}" placeholder="Album name" />
        </div>
        <div class="form-group">
            <select name="album_id" id="album_id">
                <option value="">Select...</option>
                @foreach($albums as $item)
                <option {{$item->id==$album->id?'selected':''}} value="{{$item->id}}">{{$item->album_name}}</option>
            @endforeach
            </select>
        </div>

                @include('images.partials.fileupload')
        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" id="description">{{old('description', $photo->description)}}</textarea>
        </div>



        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
