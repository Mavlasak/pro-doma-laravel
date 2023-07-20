<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Form Example Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <p>Trvání akce {{ $event->name }}</p>
    <table>
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

    <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('event.delete', $event)}}">¨
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-primary">Smazat</button>
    </form>
</div>
</body>
</html>
