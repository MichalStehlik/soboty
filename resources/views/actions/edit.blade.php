@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vytvoření nové akce</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('actions/'.$action->id.'/edit') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} row">
            <label for="name" class="col-md-4 control-label">Název</label>
            <div class="col-md-8">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name',$action->name) }}" placeholder="X. sobota s technikou" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('name') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('year') ? ' has-danger' : '' }} row">
            <label for="year" class="col-md-4 control-label">Školní rok</label>

            <div class="col-md-8">
                <input id="year" type="text" class="form-control" name="year" value="{{ old('year',$action->year) }}" placeholder="2017" required autofocus>

                @if ($errors->has('year'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('year') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('start') ? ' has-danger' : '' }} row">
            <label for="start" class="col-md-4 control-label">Začátek</label>

            <div class="col-md-8">
                <input id="start" type="datetime-local" class="form-control" name="start" value="{{ date("Y-m-d\TH:i",strtotime(old('start',$action->start))) }}" required autofocus>

                @if ($errors->has('start'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('start') }}</div>
                    </span>
                @endif
            </div>
        </div>
        
        <div class="form-group{{ $errors->has('end') ? ' has-danger' : '' }} row">
            <label for="end" class="col-md-4 control-label">Konec</label>

            <div class="col-md-8">
                <input id="end" type="datetime-local" class="form-control" name="end" value="{{ date("Y-m-d\TH:i",strtotime(old('end',$action->end))) }}" required autofocus>

                @if ($errors->has('end'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('end') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} row">
            <label for="description" class="col-md-4 control-label">Popis</label>

            <div class="col-md-8">
                <textarea id="start" class="form-control wysiwyg-simple" name="description" autofocus>{{ old('description',$action->description) }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="active" {{ old('active',$action->active) ? 'checked' : '' }}> Aktivní akce
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="public" {{ old('public',$action->public) ? 'checked' : '' }}> Zveřejněná na titulní stránce
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