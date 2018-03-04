@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vytvoření nové přihlášky</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('applications/create') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('user') ? ' has-danger' : '' }} row">
            <label for="user" class="col-md-4 control-label">Uživatel</label>

            <div class="col-md-8">
                <select id="user" class="form-control" name="user" required autofocus>
                    <option value="">-- vyberte --</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user') == $user->id) ? "selected" : "" }}>{{ $user->firstname }} {{ $user->lastname }}</option>
                    @endforeach
                </select>

                @if ($errors->has('user'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('user') }}</div>
                    </span>
                @endif
            </div>
        </div>

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

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="overCapacityAllowed" {{ old('overCapacityAllowed') ? 'checked' : '' }}> Umožnit překročit kapacitu skupiny
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