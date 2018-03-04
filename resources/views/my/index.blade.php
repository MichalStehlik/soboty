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
        </div>
        <div class="card-footer">
            <a href="{!! url('/my/edit'); !!}" class="btn btn-primary">Upravit</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Uživatelský účet
        </div>
        <div class="card-block">        
            <table class="table">
                <tr><th class="w-50">Email</th><td>{{$user->email}}</td></tr>
                <tr><th class="w-50">Propojený Facebook ID</th><td>{{$user->fb_id}}</td></tr>
                <tr><th>Role</th><td>{{$user->role}}</td></tr>
                <tr><th>Aktivní</th><td>{{($user->active == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th>Zablokovaný</th><td>{{($user->banned == 1) ? "Ano" : "Ne"}}</td></tr>
                <tr><th>Založení</th><td>{{ date('d. m. Y H:i:s', strtotime($user->created_at)) }} </td></tr>
                <tr><th>Poslední aktualizace</th><td>{{ date('d. m. Y H:i:s', strtotime($user->updated_at)) }} </td></tr>
            </table>
        </div>
    </div>
</div>
@endsection