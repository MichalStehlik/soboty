@extends('emails.app')

@section('content')
        <p>Dobrý den,</p>
        <p>tímto potvrzujeme úspěšnou registraci na naši akci.</p>
        <table class="table">
        <tr><th>Akce</th><td>{{$application->group->action->year}}\{{$application->group->action->name}}</td></tr>
        <tr><th>Skupina</th><td>{{$application->group->name}}</td></tr>
        <tr><th>Začátek akce</th><td>{{$application->group->action->start}}</td></tr>
        <tr><th>Vytvoření přihlášky</th><td>{{$application->created_at}}</td></tr>
        </table>
@endsection