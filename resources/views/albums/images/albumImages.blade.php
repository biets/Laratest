@extends('templates.layout')
@section('content')
<table class="table table-bordered">
    <tr>
        <th>Id</th>
        <th>Created date</th>
        <th>Title</th>
        <th>Album</th>
        <th>Thumbnail</th>
        <th>Delete</th>
    </tr>
    @forelse($images as $image)
    <tr>
        <td>{{$image->id}}</td>
        <td>{{$image->created_at}}</td>
        <td>{{$image->name}}</td>
        <td>{{$album->album_name}}</td>
        <td><img src="{{asset($image->img_path)}}" height="100" width="100" /></td>
        <td></td>
    </tr>
        @empty
        <tr><td colspan="5">Non ci sono immagini</td></tr>
        @endforelse
</table>
@endsection
