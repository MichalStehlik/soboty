@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Informace o skupině
        </div>
        <div class="card-block">
            <h4 class="card-title">Skupina</h4>
            <table class="table">
                <tr><th class="w-50">Název</th><td>{{$group->name}}</td></tr>
                <tr><th>Lektor</th><td>{{$user->firstname}} {{$user->lastname}}</td></tr>
                <tr><th>Nastavená kapacita</th><td>{{$group->capacity}}@if ($group->capacity < $applications->count())+{{$applications->count()-$group->capacity}}@endif </td></tr>
                <tr><th>Počet přihlášek</th><td>{{ $applications->count() }}</td></tr>
                <tr><th>Minimální ročník účastníků</th><td>@if ($group->minimal_year){{ $group->minimal_year }} @else Není uveden @endif</td></tr>
                <tr><th>Otevřená</th><td>{{($group->open == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th class="w-50">Popis</th><td>{!! $group->description !!}</td></tr>
            </table>        
            <h4 class="card-title">Akce</h4>
            <table class="table">
                <tr><th class="w-50">Název</th><td>{{$action->name}}</td></tr>
                <tr><th>Školní rok</th><td>{{$action->year}}</td></tr>
                <tr><th>Začátek</th><td>{{ date('d. m. Y H:i:s', strtotime($action->start)) }}</td></tr>
                <tr><th>Konec</th><td>{{ date('d. m. Y H:i:s', strtotime($action->end)) }}</td></tr>
                <tr><th>Aktivní</th><td>{{($action->active == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th class="w-50">Popis</th><td>{!! $action->description !!}</td></tr>
            </table>
        </div>
        <div class="card-footer">
            @can('update', $group)
            <a href="{!! url('/groups/'.$group->id."/edit"); !!}" class="btn btn-primary">Upravit</a>
            @endcan
            @can('open', $group)
            @if ($group->open)
            <a href="{!! url('/groups/'.$group->id."/close"); !!}" class="btn btn-secondary">Zavřít</a>
            @else
            <a href="{!! url('/groups/'.$group->id."/open"); !!}" class="btn btn-secondary">Otevřít</a>
            @endif
            @endcan
            @can('delete', $group)
            <a href="{!! url('/groups/'.$group->id."/delete"); !!}" class="btn btn-danger">Odstranit</a>
            @endcan
            @if ($applications->count() > 0)
            <a href="{!! url('/groups/'.$group->id."/print.certificates"); !!}" class="btn btn-secondary">Vytisknout certifikáty</a>
            <a href="{!! url('/groups/'.$group->id."/print.list"); !!}" class="btn btn-secondary">Vytisknout seznam účastníků</a>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Platné přihlášky
        </div>
        <div class="card-block">
            <table class="table">
                <tr><th>Datum a čas</th><th>Jméno</th><th>Příjmení</th><th>Pohlaví</th><th>Narození</th><th>Třída</th><th>Akce</th></tr>
                @foreach ($applications as $app)
                <tr><td>{{ date('d. m. Y H:i:s', strtotime($app->created_at)) }}</td>
                <td><a href="{!! url('/users/'.$app->user->id); !!}">{{$app->user->firstname}}</a></td>
                <td><a href="{!! url('/users/'.$app->user->id); !!}">{{$app->user->lastname}}</a></td>
                <td>{{ \App\User::genderValue[$app->user->gender] }}</td>
                <td>{{ date('d. m. Y', strtotime($app->user->birthdate)) }}</td>
                <td>{{$app->user->year}}</td>
                <td>
                    <a href="{!! url('/applications/'.$app->id); !!}" class="btn btn-secondary btn-sm">Detail</a>
                    <a href="{!! url('/applications/'.$app->id."/cancel"); !!}" class="btn btn-warning btn-sm">Zrušit</a>
                </td></tr>
                @endforeach
            </table>    
        </div>       
    </div>    
</div>
@endsection