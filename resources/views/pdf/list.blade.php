<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: sans-serif;
}
table {
    width: 100%;
}
table, th, td { 
    border: 1px solid gray;
    padding: 5px; 
    border-collapse: collapse;
    text-align: left;
}
table#settings {
    border: none;
}
table#settings th, table#settings td {
    border: none;
    text-align:left;
}
table#settings th {
    width: 25%;
}
table thead th, table thead td{
    background-color: silver;
    border-bottom: 3px solid black;
}
</style>
</head>
<body>
<h1>Seznam účastníků</h1>
<table id="settings">
<tr><th>Akce</th><td>{{ $group->action->year }} \ {{ $group->action->name }}</td></tr>
<tr><th>Skupina</th><td>{{ $group->name }}</td></tr>
<tr><th>Lektor</th><td>{{ $group->user->firstname }} {{ $group->user->lastname }}</td></tr>
<tr><th>Začátek</th><td>{{ date('d. m. Y H:i', strtotime($group->action->start )) }}</td></tr>
<tr><th>Konec</th><td>{{ date('d. m. Y H:i', strtotime($group->action->end )) }}</td></tr>
</table>
<table>
<thead>
    <tr>
    <th>Jméno</th>
    <th>Příjmení</th>
    <th>Ročník</th>
    <th>Datum narození</th>
    <th>Podpis</th>
    </tr>
</thead>
<tbody>
@foreach ($applications as $app)
    <tr>
	<td class="jmeno">{{$app->user->firstname}}</td>
    <td>{{$app->user->lastname}}</td>
    <td>{{$app->user->year}}</td>
    <td>{{ date('d. m. Y', strtotime($app->user->birthdate)) }}</td>
    <td class="podpis"></td>
    </tr>
@endforeach 
</tbody> 
</table>  
</body>
</html>