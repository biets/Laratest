@extends('templates.layout')
@section('content')
    <h1>ALBUMS</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
        {{session()->get('message')}}
        @endcomponent
    @endif
    <form>
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Album name</th>
                <th>Thumb</th>
                <th>Creator</th>
                <th>Created Date</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                @foreach($albums as $album)
                        <td>(Id: {{$album->id}}) {{$album->album_name}} ({{$album->photos_count}} pictures)</td>
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
                        <a href="{{route('album.delete', $album->id)}}" title="Delete" class="btn btn-danger">
                            <span class="fa fa-minus"></span>
                        </a>
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
    </form>
@endsection
@section('footer')
    @parent
    <script>
        $(document).ready(function () {
                $('div.alert').fadeOut(5000);

               $('ul').on('click', 'a.btn-danger', function(ele){
                    ele.preventDefault();

                    var urlAlbum = $(this).attr('href');
                    var li = ele.target.parentNode.parentNode;

                    $.ajax(urlAlbum, {
                        method: 'DELETE',
                        data: {
                            '_token': $('#_token').val()
                        },
                        complete: function (resp) {
                            console.log(resp);
                             if(resp.responseText == 1) {
                                 li.parentNode.removeChild(li);
                             }else{
                                 alert('Problem contacting server')
                             }
                        }
                    })
                })
      });
    </script>
@endsection
