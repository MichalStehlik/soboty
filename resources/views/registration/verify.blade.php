@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ověření emailové adresy</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ route('verify') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} row">
            <label for="email" class="col-md-4 control-label">E-Mailová adresa</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email',$email) }}" placeholder="neco@nekde.cz" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('code') ? ' has-danger' : '' }} row">
            <label for="code" class="col-md-4 control-label">Ověřovací kód</label>

            <div class="col-md-6">
                <input id="code" type="text" class="form-control" name="code" value="{{ old('code',$code) }}" required>

                @if ($errors->has('code'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('code') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Uložit
                </button>
                <a class="btn btn-link" href="{{ route('email.confirmation.retry',$email) }}">
                        Poslat nový kód
                    </a>
            </div>
        </div>
    </form>   
</div>
@endsection
