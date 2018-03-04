@extends('emails.app')

@section('content')
        <p>Dobrý den,</p>
        <p>obrželi jsme z Vaší emailové adresy žádost o registraci do naší aplikace.</p>
        <p>K dokončení této registrace již zbývá jen potvrdit, že vámi uvedená emailová adresa je platná a je skutečně Vaše.</p>
        <p>Nejprve malá rekapitulace:</p>
        <table class="table">
        <tr><th>Jméno a příjmení</th><td>{{$user->firstname}} {{$user->lastname}}</td></tr>
        <tr><th>Zahájení registrace</th><td>{{$user->created_at}}</td></tr>
        <tr><th>Ověřovací kód</th><td>{{$user->confirmation_code}}</td></tr>
        <tr><th>Vypršení kódu</th><td>{{$user->confirmation_validity}}</td></tr>
        </table>
        <p>Uvedený kód zadejte na adrese <a href="{{URL::route('email.confirmation')}}">{{URL::route('email.confirmation')}}</a>. Můžete také použít vygenerovaný <a href="{{URL::route('email.confirmation',["email" => $user->email, "code" => $user->confirmation_code])}}">rychlý odkaz</a>.</p>
@endsection