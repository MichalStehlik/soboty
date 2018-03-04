@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nastavení hesla uživatele</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('users/'.$user->id.'/password') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$user->id}}" />
        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} row">
            <label for="password" class="col-md-4 control-label">Nové heslo</label>
            <div class="col-md-8">
                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required autofocus>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Uložit
                </button>
            </div>
        </div>
    </form>      
</div>
@endsection