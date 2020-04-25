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
    <ul class="list-group">
    @foreach($albums as $album)
            <li class="list-group-item justify-content-between">
                {{$album->album_name}}
                <a href="/albums/{{$album->id}}/edit" class="btn btn-primary">UPDATE</a>
                <a href="/albums/{{$album->id}}" class="btn btn-danger">DELETE</a>
            </li>
        @endforeach
    </ul>
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
                    var li = ele.target.parentNode;

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
