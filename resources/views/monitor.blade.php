<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="120" />
    <title>Monitor</title>
</head>
<body>

<form name="monitoe" method="post" action="/add">
    {{ csrf_field() }}
    <input type="text" name="name">Имя сайта</br></br>
    <input type="url" name="URL">URL</br></br>
    <input type="submit" name="add" value="Добавить"></br></br>

    <table>
        @foreach($monitor as $elem)
            <tr>
                <td>{{$elem['name']}}</td>
                <td>{{$elem['URL']}}</td>
                <td><a href="/del/{{$elem['name']}}">Удалить</a></td>
                <td>{{$elem['check']}}</td>
            </tr>
        @endforeach
    </table>
</form>

</body>
</html>
