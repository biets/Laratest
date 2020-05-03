@extends('templates.layout')
@section('content')
    <h1>ALBUMS</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
        {{session()->get('message')}}
        @endcomponent
    @endif


        <table class="table table-striped">
            <thead>
            <tr>
                <th>Album name</th>
                <th>Category</th>
                <th>Thumb</th>
                <th>Creator</th>
                <th>Created Date</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>

                @foreach($albums as $album)
                    <tr id="tr{{$album->id}}">
                        <td>(Id: {{$album->id}}) {{$album->album_name}} ({{$album->photos_count}} pictures)</td>

                        <td>
                            @if($album->categories->count())
                                <ul>
                                    @foreach($album->categories as $category)
                                        <li>{{$category->category_name}} {{$category->id}}</li>
                                    @endforeach
                                </ul>
                            @else
                                No categories bound
                            @endif
                        </td>
                        <td>
                            @if($album->album_thumb)
                                <img width="120" src="{{asset($album->path)}}" title="{{$album->album_name}}" alt="{{$album->album_name}}" />
                            @endif
                        </td>
                        <td>{{$album->user->fullname}}</td>

                        <td>{{$album->created_at->format('d/m/yy H:i')}}</td>
                        <td>

                        <div class="row">
                            <div class="col-3">
                        <a href="{{route('photos.create')}}?album_id={{$album->id}}" title="Add picture" class="btn btn-success">
                            <span class="fa fa-plus"></span>
                        </a>
                            </div>
                            <div class="col-3">
                        @if($album->photos_count)
                        <a href="{{route('albums.getImages',$album->id)}}" title="View picture" class="btn">
                            <span class="fa fa-search"></span>
                        </a>
                                @else
                                    <span class="fa fa-search"></span>
                        @endif
                            </div>
                            <div class="col-3">
                        <a href="{{route('album.edit', $album->id)}}" title="Edit" class="btn btn-primary">
                            <span class="fa fa-pencil-alt"></span>
                        </a>
                            </div>
                            <div class="col-3">
                                <form id="form{{$album->id}}" method="post" action="{{route('album.delete',$album)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button id="{{$album->id}}" title="Delete album" class="btn btn-danger">
                                        <span class="fa fa-minus"></span></button>
                                </form>
                            </div>
                        </div>
                    </td>
            </tr>
        @endforeach
            <tr>
                <td class="row" colspan="5">
                    <div class="col-md-8 push-2">
                        {{$albums->links('vendor.pagination.bootstrap-4')}}
                    </div>
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

            $('table').on('click', 'button.btn-danger2', function(evt){
                evt.preventDefault();

                var id = evt.target.id;
                var f = $('#form' + id);
                var urlAlbum = f.attr('action');
                var tr = $('#tr' + id);
                console.log(tr)
                //alert("id "+id+" form "+ f + "url album"+urlAlbum+ " tr" +tr);
                $.ajax(urlAlbum, {
                    method: 'DELETE',
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    complete: function (resp) {

                        if(resp.responseText == 1) {
                            tr.remove();
                        }else{
                            alert('Problem contacting server')
                        }
                    }
                })
            })
        });

    </script>
@endsection
