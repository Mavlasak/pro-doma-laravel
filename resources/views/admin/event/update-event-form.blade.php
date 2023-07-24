@extends('layouts/@layout')

@section('content')
    <div class="card">
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="POST" action="{{route('admin.event.update', $event)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Název akce</label>
                    <input type="text" id="name" name="name" class="form-control" required="" value="{{$event->name}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Začátek akce</label>
                    <input type="datetime-local" id="event_start" name="event_start" class="form-control" required="" value="{{date('Y-m-d\TH:i', strtotime($event->event_start))}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Konec akce</label>
                    <input type="datetime-local" id="event_end" name="event_end" class="form-control" required="" value="{{date('Y-m-d\TH:i', strtotime($event->event_end))}}">
                </div>
                <div class="form-group">
                    <label><strong>Typ:</strong></label><br/>
                    <select class="form-control" name="type">
                        @foreach (\App\Models\Event::EVENT_TYPES as $key => $actionType)
                            <option value="{{$key}}" {{ ($event->type === $key ? 'selected':'') }}>{{ $actionType }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label><strong>O jaký typ akce se jedná:</strong></label><br>
                    @foreach ($eventActionTypes as $key => $type)
                        <label><input type="checkbox" name="action_type[]" value="{{$key}}" {{ ($type['checked'] ? 'checked':'') }}>{{ $type['value'] }}</label>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Poznámka</label>
                    <textarea name="note" class="form-control">{{$event->note}}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="inputFile">Vyberte soubory:</label>
                    <input
                        type="file"
                        name="files[]"
                        id="inputFile"
                        multiple
                        class="form-control @error('files') is-invalid @enderror">

                    @error('files')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="participants_count">Počet účastníků</label>
                    <input type="number" id="participants_count" name="participants_count" min="1" value="{{$event->participants_count}}">
                </div>
                <button type="submit" class="btn btn-primary">Editovat</button>
            </form>
            @foreach ($event->files as $file)
                <a href="{{route('file.download', $file)}}">
                    {{ $file->name }}
                </a>
                <form name="" id="" method="post" action="{{route('admin.file.delete', $file)}}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Smazat</button>
                </form>
            @endforeach
            <br/>
            <a href="{{route('admin.event.index')}}">
                <button type="submit" class="btn btn-primary">Zpět</button>
            </a>
        </div>
    </div>
@endsection
