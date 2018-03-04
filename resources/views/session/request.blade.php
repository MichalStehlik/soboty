@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Obnovení zapomenutého hesla</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
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

            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Odeslat
                    </button>
                </div>
            </div>
        </form>
</div>
@endsection
