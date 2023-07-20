@extends('layouts/@layout')

@section('content')
    <div class="card">
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="POST" action="{{route('event.update', $event)}}">
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
                    <textarea name="note" class="form-control">{{$event->note}}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Příloha</label>
                    <input type="text" id="attachment" name="attachment" class="form-control">
                </div>
                <div class="form-group">
                    <label for="participants_count">Počet účastníků</label>
                    <input type="number" id="participants_count" name="participants_count" min="1" value="{{$event->participants_count}}">
                </div>
                <button type="submit" class="btn btn-primary">Editovat</button>
            </form>
            <br/>
            <a href="{{route('event.index')}}">
                <button type="submit" class="btn btn-primary">Zpět</button>
            </a>
        </div>
    </div>
@endsection
