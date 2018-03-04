@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vytvoření nového osvědčení</h1>
    <p>Tato funkce slouží k vytvoření zcela nového osvědčení. Neprobíhá ověření, zda účastník uvedeného jména opravdu v dané akci byl.</p>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('certificates/create') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }} row">
            <label for="firstname" class="col-md-4 control-label">Jméno</label>
            <div class="col-md-8">
                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" placeholder="Jiří" required autofocus>

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
                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" placeholder="Novák" required autofocus>

                @if ($errors->has('lastname'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('lastname') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-check form-check-inline{{ $errors->has('gender') ? ' has-danger' : '' }} offset-md-4 col-md-2 ">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="gendermale" value="male" {{ (old('gender') == "male") ? "checked" : "" }} required autofocus>Muž</label>
            </div>
            <div class="form-check form-check-inline{{ $errors->has('gender') ? ' has-danger' : '' }} col-md-2">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="genderfemale" value="female" {{ (old('gender') == "female") ? "checked" : "" }} required autofocus>Žena</label>
            </div>
        </div>
            @if ($errors->has('gender'))
                <span class="help-block">
                    <div class="form-control-feedback">{{ $errors->first('gender') }}</div>
                </span>
            @endif

        <div class="form-group{{ $errors->has('group') ? ' has-danger' : '' }} row">
            <label for="group" class="col-md-4 control-label">Skupina</label>

            <div class="col-md-8">
                <select id="group" class="form-control" name="group" required autofocus>
                    <option value="">-- vyberte --</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}" {{ (old('group') == $group->id) ? "selected" : "" }}>{{ $group->action->year }} \ {{ $group->action->name }} \ {{ $group->name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('group'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('group') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('printdate') ? ' has-danger' : '' }} row">
            <label for="printdate" class="col-md-4 control-label">Datum vytištění osvědčení</label>

            <div class="col-md-8">
                <input id="printdate" type="date" class="form-control" name="printdate" value="{{ old('printdate') }}" required autofocus>

                @if ($errors->has('printdate'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('printdate') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Vytvořit a stáhnout
                </button>
            </div>
        </div>
    </form>      
</div>
@endsection