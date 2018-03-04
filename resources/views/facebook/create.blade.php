@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrace uživatele prostřednictvím Facebooku</h1>
    <p>Prostřednictvím Facebooku se podařilo o Vás zjistit následující informace. Prosím zkontrolujte je a chybějící doplňte.</p>
    <form class="form-horizontal" role="form" method="POST" action="{{ route('facebook.register') }}">
        {{ csrf_field() }}
        <input type="hidden" name="fb_id" value="{{ old('fb_id',$fb_id) }}">
        <h2>Osobní údaje</h2>
        <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }} row">
            <label for="firstname" class="col-md-4 control-label">Jméno</label>
            <div class="col-md-8">
                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname',$firstname) }}" placeholder="Jiří" required autofocus>

                @if ($errors->has('firstname'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('firstname') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }} row">
            <label for="lastname" class="col-md-4 control-label">Příjmení</label>

            <div class="col-md-8">
                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname',$lastname) }}" placeholder="Novák" required autofocus>

                @if ($errors->has('lastname'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('lastname') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('birthdate') ? ' has-danger' : '' }} row">
            <label for="birthdate" class="col-md-4 control-label">Datum narození</label>

            <div class="col-md-8">
                <input id="birthdate" type="date" class="form-control" name="birthdate" value="{{ old('birthdate') }}" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" placeholder="YYYY-MM-DD" required autofocus>

                @if ($errors->has('birthdate'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('birthdate') }}</div>
                    </span>
                @endif
            </div>
        </div>
        
        <div class="row">
            <div class="form-check form-check-inline{{ $errors->has('gender') ? ' has-danger' : '' }} offset-md-4 col-md-2 ">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="gendermale" value="male" required autofocus>Muž</label>
            </div>
            <div class="form-check form-check-inline{{ $errors->has('gender') ? ' has-danger' : '' }} col-md-2">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="genderfemale" value="female" required autofocus>Žena</label>
            </div>
        </div>
            @if ($errors->has('gender'))
                <span class="help-block">
                    <div class="form-control-feedback">{{ $errors->first('gender') }}</div>
                </span>
            @endif

        <h2>Škola, kterou navštěvuji</h2>
        <div class="form-group{{ $errors->has('school') ? ' has-danger' : '' }} row">
            <label for="school" class="col-md-4 control-label">Škola</label>

            <div class="col-md-8">
                <input id="school" type="text" class="form-control" name="school" value="{{ old('school') }}" placeholder="ZŠ U soudu, Liberec" autofocus>

                @if ($errors->has('school'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('school') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('year') ? ' has-danger' : '' }} row">
            <label for="year" class="col-md-4 control-label">Ročník</label>

            <div class="col-md-8">
                <select id="year" class="form-control" name="year" autofocus>
                    <option value="">--</option>
                    <option value="6">nižší než 7. třída ZŠ</option>
                    <option value="7">7. třída ZŠ</option>
                    <option value="8">8. třída ZŠ</option>
                    <option value="9">9. třída ZŠ</option>
                    <option value="10">vyšší třída (SŠ)</option>
                </select>    

                @if ($errors->has('year'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('year') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="potential_student" {{ old('potential_student') ? 'checked' : '' }}> Chci být studentem SPŠSE
                    </label>
                </div>
            </div>
        </div>

        <h2>Kontaktní údaje</h2>
        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} row">
            <label for="email" class="col-md-4 control-label">E-Mailová adresa</label>

            <div class="col-md-8">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email',$email) }}" placeholder="neco@nekde.cz" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="keep_informed" {{ old('keep_informed') ? 'checked' : '' }}> Chci být informován o Sobotách s technikou
                    </label>
                </div>
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
