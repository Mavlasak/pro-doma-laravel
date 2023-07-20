@extends('layouts/@layout')

@section('content')
    <p><b>Akce:</b> {{ $event->name }}</p>
    <p><b>Začátek akce:</b> {{ $event->event_start }}</p>
    <p><b>Konec akce:</b> {{ $event->event_end }}</p>
    <p><b>Počet účastníků:</b> {{ $event->participants_count }}</p>
    <p><b>Typ akce:</b>
        @foreach ($event->type as $type)
            {{ $type }}
        @endforeach
    </p>
    <b>Trvání akce:</b>
    <table class="table">
        <thead>
        <tr>
            <th>Dny</th>
            <th>Hodiny</th>
            <th>Minuty</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $interval['days'] }} </td>
            <td>{{ $interval['hours'] }} </td>
            <td>{{ $interval['minutes'] }} </td>
        </tr>
        </tbody>
    </table>
    <a href="{{route('event.index')}}">
        <button type="submit" class="btn btn-primary">Zpět</button>
    </a>
@endsection
