@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Informace o přihlášce
        </div>
        <div class="card-block">
            <table class="table">
                <tr><th class="w-50">Uživatel</th><td>{{$user->firstname}} {{$user->lastname}}</td></tr>
                <tr><th class="w-50">Skupina</th><td>{{$group->name}}</td></tr>
            </table>
            <h4>Vytvoření</h4>
            <table class="table">
                <tr><th class="w-50">Uživatel</th><td>{{$created->firstname}} {{$created->lastname}}</td></tr>
                <tr><th>Čas</th><td>{{ date('d. m. Y H:i:s', strtotime($application->created_at)) }} </td></tr>
            </table>
            @if ($application->cancelled_by)
            <h4>Zrušení</h4>
            <table class="table">
                <tr><th class="w-50">Uživatel</th><td>{{$cancelled->firstname}} {{$cancelled->lastname}}</td></tr>
                <tr><th>Čas</th><td>{{ date('d. m. Y H:i:s', strtotime($application->cancelled_at)) }} </td></tr>
            </table>
            @endif    
        </div>
        <div class="card-footer">
            @can('cancel', $application)
            @if(!$application->cancelled_by)
            <a href="{!! url('/applications/'.$application->id."/cancel"); !!}" class="btn btn-warning">Zrušit</a>
            @endif
            @endcan
            @can('delete', $application)
            <a href="{!! url('/applications/'.$application->id."/delete"); !!}" class="btn btn-danger">Odstranit</a>
            @endcan
        </div>
    </div>
</div>
@endsection