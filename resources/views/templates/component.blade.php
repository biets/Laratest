@extends('templates.layout')
@section('title', $title)
@section('content')
    <h1>{{$title}} B</h1>

    @if($staff)
        <ul>
            @foreach($staff as $person)
                <li> {{$loop->first}} {{$loop->last}} {{$loop->remaining}} {{$person['name']}} {{$person['lastname']}} </li>
            @endforeach
        </ul>
    @endif
    <ul>
        @forelse ($staff as $person)
            <li> {{$person['name']}} {{$person['lastname']}} </li>
        @empty
            <li>no staff</li>
        @endforelse
    </ul>

    @for($i = 0; $i<count($staff); $i++)
        {{ $staff[$i]['name'] }}
    @endfor


@endsection
@section('footer')
    @parent
    <script>
        alert('footer');
    </script>
@stop

