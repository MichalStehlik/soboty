@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
        <div class="col col-12 col-md-8">
            <div class="jumbotron">
                <h1 class="display-3">Soboty s technikou</h1>
                <p class="lead">Soboty s technikou jsou série akcí pořádaných SPŠSE a VOŠ Liberec pro zájemce o strojírenství, elektrotechniku, informační a komunikační technologie nebo matematiku s fyzikou.</p>
                <p>Jsou zaměřené zejména na potenciální studenty SPŠSE z 8. a 9. tříd ZŠ. Pro žáky z nižších ročníků organizujeme kurzy v rámci <a href="http://detskauniverzita.tul.cz/">Dětské univerzity</a>.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{url("register")}}" role="button">Registrace</a>
                </p>
            </div>
        </div>
        <div class="col col-12 col-md-4">
            <div class="card">
            @if (Auth::guest())
                <div class="card-block">
                    <h4 class="card-title">Příhlášení</h4>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                            <label for="email" class="col-12 control-label">E-Mailová adresa</label>
                            <div class="col-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                            <label for="password" class="col-12 control-label">Heslo</label>
                            <div class="col-12">
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Dlouhodobé přihlášení
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    Přihlásit
                                </button>
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Zapomenuté heslo?
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <a class="btn btn-social btn-facebook" href="{{ route('facebook') }}"><i class="fa fa-facebook fa-fw"></i>Facebook</a>
                            </div>
                        </div>
                    </form>
                </div>       
            @else
                <div class="card-block">
                    <h4 class="card-title">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h4>
                    <div><a href="{{ route("personal.profile") }}" class="btn btn-secondary">Profil</a> <a href="{{ route('logout') }}" class="btn btn-secondary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odhlášení</a></div>
                </div>  
                @if ($userApplications->count() > 0)
                <table class="table table-striped">
                @foreach ($userApplications as $ua)
                    <tr>
                        <td class="{{$ua->cancelled_at ? "table-danger" : ""}}"><small>{{$ua->group->action->year}}\{{$ua->group->action->name}}</small><br>{{$ua->group->name}}<br><small>Vytvořeno: {{$ua->created_at}}@if($ua->cancelled_at)<br>Zrušeno: {{$ua->cancelled_at}}@endif</small></td>
                    </tr>
                @endforeach
                </table>
                <div class="card-block">
                    <div><a href="{{ route("personal.applications") }}" class="btn btn-secondary">Všechny přihlášky</a></div>
                @else
                <div class="card-block">  
                    <p>Žádné přihlášky zatím nemáte.</p>
                @endif
                </div>
            </div>    
            @endif  
        </div>
    </div>
    <section id="actions">
    @foreach ($actions as $action)
        <div>
            <header>
                <h1>{{ $action->name }}</h1>
                <p>{{ date('d. m. Y H:i', strtotime($action->start)) }} &ndash; {{ date('d. m. Y H:i', strtotime($action->end)) }}</p>
            </header>
            <div>
                {!! $action->description !!}
            </div>
            @if ($applications[$action->id])
            <div class="applications">
                <h2>Jste přihlášení:</h2>
                @foreach ($applications[$action->id] as $app)
                <div class="card" style="background-color: rgb(230,230,230)">
                    <div class="card-block">
                        <h3 class="card-title">{{ $app->name }}</h3>
                        <p class="card-text">{!! $app->description !!}</p>
                        <div class="buttons">@if ($app->open)<a href="{{ route('leave',[$app->id]) }}" class="btn btn-danger">Odhlásit se</a> @endif </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            <div class="actions-cards">
                <div class="row">
                @foreach ($groups[$action->id] as $group)
                    <div class="card col-md-4">
                        <div class="card-block">
                            <h3 class="card-title">{{$group->name}}</h3>
                            <p class="card-text">{!! $group->description !!}</p>
                        </div>
                        <div class="card-block">
                            @if (Auth::guest() || $applications[$action->id])

                            @else
                                @if ($group->open && ($group->applications < $group->capacity))
                                    <a href="{{ route('sign',[$group->id]) }}" class="btn btn-success">Zapsat se</a> 
                                @else
                                    <button type="button" class="btn btn-secondary" disabled>Zapsat se</button>   
                                @endif    
                            @endif
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#infoModal" data-group="{{ $group->id }}">Podrobnosti</button>    
                        </div>   
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-3 attendees" style="font-size: small;">{{$group->applications}}/{{max($group->capacity,$group->applications)}}</div>
                                <div class="progress col-9">
                                    <div class="progress-bar {{(($group->applications / max($group->capacity,$group->applications)) < 1) && ($group->open) ? "bg-success" : "bg-danger"}} progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{($group->applications / max($group->capacity,$group->applications)) * 100}}%" aria-valuenow="{{$group->applications}}" aria-valuemin="0" aria-valuemax="{{max($group->capacity,$group->applications)}}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>                 
        </div>
    @endforeach
    </section>
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="infoName">?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="infoDescription"></div>  
              <table class="table">
                <tr><th>Kapacita</th><td id="infoCapacity">?</td></tr>
                <tr><th>Přihlášky</th><td id="infoApplications">?</td></tr>
                <tr><th>Minimální ročník ZŠ</th><td id="infoYear">?</td></tr>
                <tr><th>Lektor</th><td id="infoLector">?</td></tr>
              </table>  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        var api = "{{ url("/api") }}";
        $('#infoModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var groupId = button.data('group');
            var modal = $(this);
            $.getJSON(api + "/groups/" + groupId)
                .done(function(data) {
                    modal.find('.modal-title').text(data.name);
                    modal.find('#infoDescription').html(data.description);
                    if (data.capacity > data.applications) 
                        modal.find('#infoCapacity').text(data.capacity);
                    else
                        modal.find('#infoCapacity').text(data.applications);    
                    if (data.minimal_year) 
                        modal.find('#infoYear').text(data.minimal_year);
                    else
                        modal.find('#infoYear').html("<em>není nastaven</em>");    
                    modal.find('#infoLector').html(data.lectorFirstname + " " + data.lectorLastname);
                    modal.find('#infoApplications').text(data.applications);
                });
        });
    });
</script>
@endsection