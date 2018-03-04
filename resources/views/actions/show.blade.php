@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Informace o akci
        </div>
        <div class="card-block">
            <h4 class="card-title">Obecné</h4>
            <table class="table">
                <tr><th class="w-50">Název</th><td>{{$action->name}}</td></tr>
                <tr><th>Školní rok</th><td>{{$action->year}}</td></tr>
                <tr><th>Začátek</th><td>{{ date('d. m. Y H:i:s', strtotime($action->start)) }}</td></tr>
                <tr><th>Konec</th><td>{{ date('d. m. Y H:i:s', strtotime($action->end)) }}</td></tr>
                <tr><th>Aktivní</th><td>{{($action->active == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th>Veřejná</th><td>{{($action->public == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><td colspan="2">
                    <p>Aktivní akce znamená, že se objevuje v seznamu akcí a je možné v ní vytvářet skupiny. Aby bylo možné se na akci zapisovat je nutné odemknout skupiny (dole).</p>
                    <p>Veřejná akce je akce, která je viditelná na titulní stránce.</p>
                </td></tr>
                <tr><th class="w-50">Popis</th><td>{!! $action->description !!}</td></tr>
            </table>
            <h4 class="card-title">Založení</h4>
            <table class="table">
                <tr><th>Založení</th><td>{{ date('d. m. Y H:i:s', strtotime($action->created_at)) }} </td></tr>
                <tr><th>Poslední aktualizace</th><td>{{ date('d. m. Y H:i:s', strtotime($action->updated_at)) }} </td></tr>
                <tr><th>Vytvořil</th><td>{{ $user->firstname }} {{ $user->lastname }}</td></tr>
            </table>
        </div>
        <div class="card-footer">
            @can('update', $action)
            <a href="{!! url('/actions/'.$action->id."/edit"); !!}" class="btn btn-primary">Upravit</a>
            @endcan
            @can('activate', $action)
            @if ($action->active)
            <a href="{!! url('/actions/'.$action->id."/deactivate"); !!}" class="btn btn-secondary">Deaktivovat</a>
            @else
            <a href="{!! url('/actions/'.$action->id."/activate"); !!}" class="btn btn-secondary">Aktivovat</a>
            @endif
            @if ($action->public)
            <a href="{!! url('/actions/'.$action->id."/hide"); !!}" class="btn btn-secondary">Skrýt</a>
            @else
            <a href="{!! url('/actions/'.$action->id."/publish"); !!}" class="btn btn-secondary">Zveřejnit</a>
            @endif
            @endcan
            @can('delete', $action)
            <a href="{!! url('/actions/'.$action->id."/delete"); !!}" class="btn btn-danger">Odstranit</a>
            @endcan
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Skupiny
        </div>
        <div class="card-block">
        @if ($groups->count() > 0)
        <table class="table">
        <thead><tr><th>Název</th><th>Kapacita</th><th>Přihlášek</th><th>Otevřená</th></tr></thead>
        <tbody>
        @foreach ($groups as $group)
            <tr>
                <td><a href="{!! url('/groups/'.$group->id); !!}">{{$group->name}}</a></td>
                <td>{{$group->capacity}}</td>
                <td>{{$group->count}}</td>
                <td>{{($group->open == 1) ? "Ano" : "Ne"}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr><td>Celkem</td><td>{{ $groups->sum("capacity") }}</td><td>{{ $groups->sum("count") }}</td><td></td></tr>
        </tfoot>
        </table>
        @else
        <p>V této akci nejsou žádné skupiny.</p>
        @endif
        </div>
        <div class="card-footer">
            @can('create', "App\Group")
            <a href="{!! url("/groups/create"); !!}?action={{$action->id}}" class="btn btn-success">Vytvořit novou skupinu</a>
            @endcan
            @can('open', $action)
            <a href="{!! url('/actions/'.$action->id."/open"); !!}" class="btn btn-secondary">Všechny otevřít</a>
            <a href="{!! url('/actions/'.$action->id."/close"); !!}" class="btn btn-secondary">Všechny zavřít</a>
            @endcan
        </div>
    </div>    
</div>
@endsection