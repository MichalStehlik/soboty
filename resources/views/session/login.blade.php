@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Přihlášení uživatele</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                <label for="email" class="col-md-4 control-label">E-Mailová adresa</label>

                <div class="col-md-8">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
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
                <div class="col-md-8 offset-md-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Dlouhodobé přihlášení
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Přihlásit
                    </button>

                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Zapomenuté heslo?
                    </a>
                </div>
            </div>
        </form>
</div>
@endsection
