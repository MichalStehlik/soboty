@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Informace o uživateli
        </div>
        <div class="card-block">
            <h4 class="card-title">Osobní</h4>
            <table class="table">
                <tr><th class="w-50">Jméno</th><td>{{$user->firstname}}</td></tr>
                <tr><th>Příjmení</th><td>{{$user->lastname}}</td></tr>
                <tr><th>Datum narození</th><td>{{ date('d. m. Y', strtotime($user->birthdate)) }}</td></tr>
                <tr><th>Pohlaví</th><td>{{ \App\User::genderValue[$user->gender] }}</td></tr>
            </table>
            <h4 class="card-title">Škola</h4>
            <table class="table">
                <tr><th class="w-50">Název</th><td>{{$user->school}}</td></tr>
                <tr><th>Ročník (ZŠ)</th><td>{{$user->year}}</td></tr>
                <tr><th>Potenciální student</th><td>{{($user->potential_student == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th>Odběratel emailu</th><td>{{($user->keep_informed == 1) ? "Ano" : "Ne"}}</td></tr>
            </table>
            <h4 class="card-title">Uživatelský účet</h4>
            <table class="table">
                <tr><th class="w-50">Email</th><td>{{$user->email}}</td></tr>
                <tr><th>Facebook ID</th><td> @if ($user->fb_id) <a href="https://facebook.com/{{$user->fb_id}}">{{$user->fb_id}}</a> @else není @endif</td></tr>
                <tr><th>Role</th><td>{{$user->role}}</td></tr>
                <tr><th>Aktivní</th><td>{{($user->active == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th>Zablokovaný</th><td>{{($user->banned == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th>Potvrzený email</th><td>{{($user->email_confirmed == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th>Platnost potvrzovacího kódu</th><td>@if ($user->confirmation_expiration){{ date('d. m. Y H:i:s', strtotime($user->confirmation_expiration)) }} @else &mdash; @endif</td></tr>
                <tr><th>Platnost tokenu pro změnu hesla</th><td>@if ($user->request_expiration){{ date('d. m. Y H:i:s', strtotime($user->request_expiration)) }} @else &mdash; @endif</td></tr>
                <tr><th>Založení</th><td>{{ date('d. m. Y H:i:s', strtotime($user->created_at)) }} </td></tr>
                <tr><th>Poslední aktualizace</th><td>{{ date('d. m. Y H:i:s', strtotime($user->updated_at)) }} </td></tr>
            </table>
        </div>
        <div class="card-footer">
            @can('update', $user)
            <a href="{!! url('/users/'.$user->id."/edit"); !!}" class="btn btn-primary">Upravit</a>
            <a href="{!! url('/users/'.$user->id."/password"); !!}" class="btn btn-secondary">Nastavit heslo</a>
            @endcan
            @can('ban', $user)
            @if ($user->banned)
            <a href="{!! url('/users/'.$user->id."/unban"); !!}" class="btn btn-secondary">Odblokovat</a>
            @else
            <a href="{!! url('/users/'.$user->id."/ban"); !!}" class="btn btn-secondary">Zablokovat</a>
            @endif
            @endcan
            @can('delete', $user)
            <a href="{!! url('/users/'.$user->id."/delete"); !!}" class="btn btn-danger">Odstranit</a>
            @endcan
        </div>
    </div>
    @if ($applications)
    <div class="card">
        <div class="card-header">
            Přihlášky uživatele
        </div>
        <div class="card-block">
            <table class="table">
                <thead>
                    <tr>
                        <th>Rok</th>
                        <th>Akce</th>
                        <th>Skupina</th>
                        <th>Vytvořeno</th>
                        <th>Zrušeno</th>
                        <th>Možnosti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $app)
                    <tr>
                        <td>{{$app->group->action->year}}</td>
                        <td><a href="{!! url('/actions/'.$app->group->action->id); !!}">{{$app->group->action->name}}</a></td>
                        <td><a href="{!! url('/groups/'.$app->group->id); !!}">{{$app->group->name}}</a></td>
                        <td>{{$app->created_at}}</td>
                        <td>{{$app->cancelled_at}}</td>
                        <td>
                            <a href="{!! url('/applications/'.$app->id); !!}" class="btn btn-secondary btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>    
        </div>
    </div>
    @endif
</div>
@endsection