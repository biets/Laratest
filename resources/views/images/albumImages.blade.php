@extends('templates.layout')
@section('content')

    <h1>Images for {{$album->album_name}}</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif

<table class="table table-striped">
    <thead>
    <tr>
        <th>Id</th>
        <th>Created date</th>
        <th>Title</th>
        <th>Album</th>
        <th>Thumbnail</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    @forelse($images as $image)
    <tr>
        <td>{{$image->id}}</td>
        <td>{{$image->created_at->format('d/m/yy H:i')}}</td>
        <td>{{$image->name}}</td>
        <td><a href="{{route('album.edit', $image->album_id)}}" >{{$album->album_name}}</a></td>
        <td><img src="{{asset($image->img_path)}}" height="100" /></td>

        <td>
            <a href="{{route('photos.edit', $image->id)}}" title="Edit" class="btn btn-primary">
                <span class="fa fa-pencil-alt"></span>
            </a>
            <a href="{{route('photos.destroy', $image->id)}}" title="Delete" class="btn btn-danger">
                <span class="fa fa-minus"></span>
            </a>
        </td>
    </tr>
        @empty
        <tr><td colspan="5">Non ci sono immagini</td></tr>
        @endforelse
    <tr>
        <td colspan="6" class="text-center">
                    {{$images->links('vendor.pagination.bootstrap-4')}}
        </td>

    </tr>
    </tbody>
</table>
@endsection
@section('footer')
    @parent
    <script>
        $(document).ready(function () {
            $('div.alert').fadeOut(5000);

            $('table').on('click', 'a.btn-danger', function(ele){
                ele.preventDefault();

                var urlAlbum = $(this).attr('href');
                var tr = ele.target.parentNode.parentNode;

                $.ajax(urlAlbum, {
                    method: 'DELETE',
                    data: {
                        '_token': '{{csrf_token()}}'
                    },

                    complete: function (resp) {
                        console.log(resp);
                        if(resp.responseText == 1) {
                            tr.parentNode.removeChild(tr);
                        }else{
                            alert('Problem contacting server')
                        }
                    }
                })
            })
        });
    </script>
@endsection
