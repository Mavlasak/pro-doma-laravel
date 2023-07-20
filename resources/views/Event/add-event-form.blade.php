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
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Laravel 8 - Add Blog Post Form Example
        </div>
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('event.store')}}">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Název akce</label>
                    <input type="text" id="name" name="name" class="form-control" required="" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Začátek akce</label>
                    <input type="datetime-local" id="event_start" name="event_start" class="form-control" required="" value="{{ old('event_start') }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Konec akce</label>
                    <input type="datetime-local" id="event_end" name="event_end" class="form-control" required="" value="{{ old('event_end')}}">
                </div>
                <div class="">
                    <label><strong>Typ akce :</strong></label><br/>
                    <select class="form-control" name="type[]" multiple="">
                        @foreach ($eventTypes as $key => $type)
                            <option value="{{$key}}" {{ ($type['selected'] ? 'selected':'') }}>{{ $type['value'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Poznámka</label>
                    <textarea name="note" class="form-control">{{ old('note')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Příloha</label>
                    <input type="text" id="attachment" name="attachment" class="form-control">
                </div>
                <div class="form-group">
                    <input type="number" id="participants_count" name="participants_count" min="1" max="50" value="{{ old('participants_count')}}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
