    <nav class="navbar navbar-toggleable-md fixed-top navbar-light bg-faded">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Soboty s technikou') }}</a>
      
      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav mr-auto">
          @can('viewList', App\Action::class)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{!! url('/actions'); !!}" id="action01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Akce</a>
            <div class="dropdown-menu" aria-labelledby="action01">
              @can('viewList', App\Action::class)<a class="dropdown-item" href="{!! url('/actions'); !!}">Seznam</a> @endcan
              @can('create', App\Action::class)<a class="dropdown-item" href="{!! url('/actions/create'); !!}">Nová</a> @endcan
            </div>
          </li>
          @endcan
          @can('viewList', App\Group::class)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{!! url('/groups'); !!}" id="action02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Skupiny</a>
            <div class="dropdown-menu" aria-labelledby="action02">
              @can('viewList', App\Group::class)<a class="dropdown-item" href="{!! url('/groups'); !!}">Seznam</a> @endcan
              @can('create', App\Group::class)<a class="dropdown-item" href="{!! url('/groups/create'); !!}">Nová</a> @endcan
            </div>
          </li>
          @endcan
          @can('viewList', App\Application::class)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{!! url('/applications'); !!}" id="action04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Přihlášky</a>
            <div class="dropdown-menu" aria-labelledby="action04">
              @can('viewList', App\Application::class)<a class="dropdown-item" href="{!! url('/applications'); !!}">Seznam</a> @endcan
              @can('create', App\Application::class)<a class="dropdown-item" href="{!! url('/applications/create'); !!}">Nová</a> @endcan
              @can('create', App\Application::class)<a class="dropdown-item" href="{!! url('/certificates/create'); !!}">Vytvořit osvědčení</a> @endcan
            </div>
          </li>
          @endcan
          @can('viewList', App\User::class)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{!! url('/users'); !!}" id="action03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Uživatelé</a>
            <div class="dropdown-menu" aria-labelledby="action03">
              @can('viewList', App\User::class) <a class="dropdown-item" href="{!! url('/users'); !!}">Seznam</a> @endcan
              @can('create', App\User::class) <a class="dropdown-item" href="{!! url('/users/create'); !!}">Nový</a> @endcan
            </div>
          </li>
          @endcan
        </ul>
        <ul class="navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if (Auth::guest())
            <li><a class="nav-link" href="{{ route('login') }}">Přihlášení</a></li>
            <li><a class="nav-link" href="{{ route('register') }}">Registrace</a></li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('personal.profile') }}">Profil</a>
                        <a class="dropdown-item" href="{{ route('personal.applications') }}">Přihlášky</a>
                        <a  class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                            Odhlášení
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        @endif          
        </ul>
      </div>
    </nav>