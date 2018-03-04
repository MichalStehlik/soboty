@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editace skupiny</h1>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('groups/'.$group->id.'/edit') }}">
        {{ csrf_field() }}
        <input name="id" type="hidden" value="{{ old('id',$group->id) }}">
        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} row">
            <label for="name" class="col-md-4 control-label">Název</label>
            <div class="col-md-8">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name',$group->name) }}" placeholder="Název skupiny" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('name') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('action') ? ' has-danger' : '' }} row">
            <label for="year" class="col-md-4 control-label">Akce</label>

            <div class="col-md-8">
                <select id="action" class="form-control" name="action" required autofocus>
                    <option value="">-- vyberte --</option>
                    @foreach ($actions as $action)
                    <option value="{{ $action->id }}" {{ (old('action',$group->actions_id) == "$action->id") ? "selected" : "" }}>{{ $action->year }} \ {{ $action->name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('action'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('action') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('lector') ? ' has-danger' : '' }} row">
            <label for="year" class="col-md-4 control-label">Lektor</label>

            <div class="col-md-8">
                <select id="lector" class="form-control" name="lector" required autofocus>
                    <option value="">-- vyberte --</option>
                    @foreach ($lectors as $lector)
                    <option value="{{ $lector->id }}" {{ (old('lector',$group->users_id) == $lector->id) ? "selected" : "" }}>{{ $lector->firstname }} {{ $lector->lastname }}</option>
                    @endforeach
                </select>

                @if ($errors->has('action'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('lector') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('capacity') ? ' has-danger' : '' }} row">
            <label for="capacity" class="col-md-4 control-label">Kapacita</label>

            <div class="col-md-8">
                <input id="start" type="number" class="form-control" name="capacity" value="{{ old('capacity',$group->capacity) }}" required autofocus>

                @if ($errors->has('capacity'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('capacity') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('minimal_year') ? ' has-danger' : '' }} row">
            <label for="minimal_year" class="col-md-4 control-label">Minimální ročník</label>

            <div class="col-md-8">
                <select id="minimal_year" class="form-control" name="minimal_year" autofocus>
                    <option value="">-- vyberte --</option>
                    <option value="6" {{ (old('minimal_year',$group->minimal_year) == "6") ? "selected" : "" }}>nižší než 7. třída ZŠ</option>
                    <option value="7" {{ (old('minimal_year',$group->minimal_year) == "7") ? "selected" : "" }}>7. třída ZŠ</option>
                    <option value="8" {{ (old('minimal_year',$group->minimal_year) == "8") ? "selected" : "" }}>8. třída ZŠ</option>
                    <option value="9" {{ (old('minimal_year',$group->minimal_year) == "9") ? "selected" : "" }}>9. třída ZŠ</option>
                    <option value="10" {{ (old('minimal_year',$group->minimal_year) == "10") ? "selected" : "" }}>vyšší třída (SŠ)</option>
                </select>    

                @if ($errors->has('minimal_year'))
                    <span class="help-block">
                        <div class="form-control-feedback">{{ $errors->first('minimal_year') }}</div>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} row">
            <label for="description" class="col-md-4 control-label">Popis</label>

            <div class="col-md-8">
                <textarea id="start" class="form-control wysiwyg-simple" name="description" autofocus>{{ old('description',$group->description) }}</textarea>

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
                        <input type="checkbox" name="open" {{ old('open',$group->open) ? 'checked' : '' }}> Otevřená pro zápis
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