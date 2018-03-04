@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Obnovení zapomenutého hesla</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.set') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                <label for="email" class="col-md-4 control-label">E-Mailová adresa</label>

                <div class="col-md-8">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email',$email) }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }} row">
                <label for="code" class="col-md-4 control-label">Ověřovací kód</label>

                <div class="col-md-8">
                    <input id="code" type="test" class="form-control" name="code" value="{{ old('code',$code) }}" required autofocus>

                    @if ($errors->has('token'))
                        <span class="help-block">
                            <div class="form-control-feedback">{{ $errors->first('code') }}</div>
                        </span>
                    @endif
                </div>
            </div>

        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} row">
            <label for="password" class="col-md-4 control-label">Heslo</label>

            <div class="col-md-8">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 control-label">Heslo ještě jednou</label>

            <div class="col-md-8">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Nastavit
                    </button>
                </div>
            </div>
        </form>
</div>
@endsection
