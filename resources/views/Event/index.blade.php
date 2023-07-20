<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Form Example Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container-fluid">
        <form name="add-blog-post-form" class="form-inline" id="add-blog-post-form" method="GET" action="{{route('event.index')}}">
            @csrf
            <label for="name" class="m-2">Název akce</label>
            <input type="text" id="name" name="name" class="form-control" value="{{$filter['name']}}">
            <label for="event_start" class="m-2">Začátek</label>
            <input type="datetime-local" id="event_start" name="event_start" class="form-control" value="{{$filter['event_start']}}">
            <label for="event_end" class="m-2">Začátek</label>
            <input type="datetime-local" id="event_end" name="event_end" class="form-control" value="{{$filter['event_end']}}">
            <label>Typ akce</label><br/>
            <select class="form-control" name="type[]">
                <option></option>
                @foreach ($eventTypes as $key => $type)
                    <option value="{{$key}}" {{ ($type['selected'] ? 'selected':'') }}>{{ $type['value'] }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary m-2">Vyhledat</button>
        </form>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Název akce</th>
            <th>Začátek akce</th>
            <th>Konec akce</th>
            <th>Typ akce</th>
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
                    @foreach ($event->type as $type)
                        {{ $type }}
                    @endforeach
                </td>
                <td>{{ $event->participants_count }}</td>
                <td>
                    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('event.delete', $event)}}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Smazat</button>
                    </form>
                    <a href="{{route('event.edit', $event)}}">
                        <button type="submit" class="btn btn-primary">Editovat</button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
