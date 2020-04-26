@extends('templates.layout')
@section('content')

    <h1>Create</h1>

    <form action="/albums/" method="POST">
        {{csrf_field()}}

        <input type="hidden" name="user_id" value="1" />
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="" placeholder="Album name" />
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" id="description"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
