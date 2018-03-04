@extends('layouts.app')

@section('content')
<div class="container">
    @if ($applications->count() > 0)
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $app)
                    <tr>
                        <td>{{$app->group->action->year}}</td>
                        <td>{{$app->group->action->name}}</td>
                        <td>{{$app->group->name}}</td>
                        <td>{{$app->created_at}}</td>
                        <td>{{$app->cancelled_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>    
        </div>
    </div>
    @else
    <p>Žádné přihlášky nemáte.</p>
    @endif
</div>
@endsection