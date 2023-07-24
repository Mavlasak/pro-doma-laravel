@extends('layouts/@layout')

@section('content')
    <div class="container-fluid">
        <form name="add-blog-post-form" class="form-inline" id="add-blog-post-form" method="GET" action="{{route('admin.event.index')}}">
            @csrf
            <label for="name" class="m-2">Název akce</label>
            <input type="text" id="name" name="name" class="form-control" value="{{$filter['name']}}">
            <label for="event_start" class="m-2">Začátek</label>
            <input type="datetime-local" id="event_start" name="event_start" class="form-control" value="{{$filter['event_start']}}">
            <label for="event_end" class="m-2">Začátek</label>
            <input type="datetime-local" id="event_end" name="event_end" class="form-control" value="{{$filter['event_end']}}">
            <label>Typ akce</label><br/>
            <select class="form-control" name="type">
                <option></option>
                @foreach (\App\Models\Event::EVENT_TYPES as $key => $type)
                    <option value="{{$key}}" {{ ($filter['type'] === $key ? 'selected':'') }}>{{ $type }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary m-2">Vyhledat</button>
        </form>
        <a href="{{route('admin.event.new')}}">
            <button class="btn btn-primary">Přidat událost</button>
        </a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Název akce</th>
            <th>Začátek akce</th>
            <th>Konec akce</th>
            <th>Typ akce</th>
            <th>O jaký typ akce se jedná</th>
            <th>Počet účastníků</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($events as $event)
            <tr>
                <td>
                    <a href="{{route('event.detail', $event)}}">
                        {{ $event->name }}
                    </a>
                </td>
                <td>{{ $event->event_start }}</td>
                <td>{{ $event->event_end }}</td>
                <td>
                    {{ \App\Models\Event::EVENT_TYPES[$event->type] }}
                </td>
                <td>
                    @foreach ($event->action_type as $actionType)
                        {{ \App\Models\Event::EVENT_ACTION_TYPES[$actionType] }}
                    @endforeach
                </td>
                <td>{{ $event->participants_count }}</td>
                <td>
                    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('admin.event.delete', $event)}}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Smazat</button>
                    </form>
                    <a href="{{route('admin.event.edit', $event)}}">
                        <button type="submit" class="btn btn-primary">Editovat</button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
