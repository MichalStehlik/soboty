@extends('emails.app')

@section('content')
        <p>Dobrý den,</p>
        <p>obrželi jsme z Vaší emailové adresy žádost o obnovení hesla k přístupu do naší aplikace.</p>
        <p>K dokončení této registrace již zbývá jen potvrdit, že vámi uvedená emailová adresa je platná a je skutečně Vaše.</p>
        <p>Nejprve malá rekapitulace:</p>
        <table class="table">
        <tr><th>Ověřovací kód</th><td>{{$user->request_token}}</td></tr>
        <tr><th>Vypršení kódu</th><td>{{$user->request_expiration}}</td></tr>
        </table>
        <p>Uvedený kód zadejte na adrese <a href="{{URL::route('password.set')}}">{{URL::route('password.set')}}</a>. Můžete také použít vygenerovaný <a href="{{URL::route('password.set',["email" => $user->email, "code" => $user->request_token])}}">rychlý odkaz</a>.</p>
@endsection