<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link">
    <img src="{{ asset('assets/img/brasao_caraguatatuba_prefeitura.png') }}"
         alt="EXAMES Caraguatatuba logo"
         class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">
      <b>{{ trans('application.config.name') }}</b>{{ trans('application.config.nickname') }}
    </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar User (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <i class="fas fa-user-circle fa-2x text-muted"></i>
      </div>
      <div class="info">
        <a href="{{ route('users.show', [ Auth::user()->id ]) }}" class="d-block ellipsis">{{ Auth::user()->name }}</a>
        <a>{{ str_limit(ucwords(Auth::user()->unidade->nome), $limit = 35, $end = '...') }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">

      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @if(Auth::user()->hasRole('ADMIN'))

        <!-- Dashboard -->

        {{-- <li class="nav-item">
          <a href="{{ route('dashboard.panel') }}" class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
              {{ trans('menus.sidebar.item.dashboard') }}
              <span class="right badge {{ (Request::is('dashboard') ? 'badge-light' : 'badge-danger') }}">
                {{ trans('menus.sidebar.item.panel') }}
              </span>
            </p>
          </a>
        </li> --}}

        <!-- Logs -->

        <li class="nav-item">
          <a href="{{ route('logs.index') }}" class="nav-link {{ (Request::is('logs') ? 'active' : '') }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
              {{ trans('menus.sidebar.item.logs') }}
            </p>
          </a>
        </li>

        @endif

        @if(Auth::user()->hasRole('ADMIN') || Auth::user()->hasRole('LAB'))

          <!-- Users -->

          <li class="nav-item has-treeview {{ (Request::is('users') || Request::is('users/*') ? 'menu-open' : '') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                {{ trans('menus.sidebar.item.users') }}

                @include('templates/parts/_sidebar__resource-marker', ['resource' => 'users'])

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ (Request::is('users') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('users') ? 'text-info' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.list') }}</p>
                </a>
              </li>

              @if(Auth::user()->hasRole('ADMIN'))
                <li class="nav-item">
                  <a href="{{ route('users.create') }}" class="nav-link {{ (Request::is('users/create') ? 'active' : '') }}">
                    <i class="far fa-circle nav-icon {{ (!Request::is('users/create') ? 'text-success' : '') }}"></i>
                    <p>{{ trans('menus.sidebar.action.add') }}</p>
                  </a>
                </li>
              @endif

            </ul>
          </li>

        @endif

          <!-- Solicitacoes -->

        @if(Auth::user()->hasRole('LAB') || Auth::user()->hasRole('GERENTE') || Auth::user()->hasRole('ADMIN'))

          <li class="nav-item has-treeview {{ (Request::is('solicitacoes') || Request::is('solicitacoes/*') ? 'menu-open' : '') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-notes-medical"></i>
              <p>
                {{ trans('menus.sidebar.item.solicitacoes') }}

                @include('templates/parts/_sidebar__resource-marker', ['resource' => 'solicitacoes'])

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('solicitacoes.index') }}" class="nav-link {{ (Request::is('solicitacoes') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('solicitacoes') ? 'text-info' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.list') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('solicitacoes.create') }}" class="nav-link {{ (Request::is('solicitacoes/create') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('solicitacoes/create') ? 'text-success' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.add') }}</p>
                </a>
              </li>

            </ul>
          </li>

        @endif

        @if(Auth::user()->hasRole('UNIDADE'))

          <!-- Exames -->

          <li class="nav-item has-treeview {{ (Request::is('exames') || Request::is('exames/*') ? 'menu-open' : '') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-flask"></i>
              <p>
                {{ trans('menus.sidebar.item.exames') }}

                @include('templates/parts/_sidebar__resource-marker', ['resource' => 'exames'])

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{ route('pendentes.index') }}" class="nav-link {{ (Request::is('pendentes') ? 'active' : '') }}">
                    <i class="far fa-circle nav-icon {{ (!Request::is('pendentes') ? 'text-info' : '') }}"></i>
                    <p>{{ trans('menus.sidebar.subitem.pendentes') }}</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('aguardando.index') }}" class="nav-link {{ (Request::is('aguardando') ? 'active' : '') }}">
                    <i class="far fa-circle nav-icon {{ (!Request::is('aguardando') ? 'text-warning' : '') }}"></i>
                    <p>{{ trans('menus.sidebar.subitem.aguardando') }}</p>
                  </a>
                </li>

              <li class="nav-item">
                <a href="{{ route('aprovados.index') }}" class="nav-link {{ (Request::is('aprovados') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('aprovados') ? 'text-success' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.subitem.aprovados') }}</p>
                </a>
              </li>

            </ul>
          </li>

        @endif

          <!-- Unidades -->

        @if(Auth::user()->hasRole('LAB') || Auth::user()->hasRole('GERENTE') || Auth::user()->hasRole('ADMIN'))

          <li class="nav-item has-treeview {{ (Request::is('unidades') || Request::is('unidades/*') ? 'menu-open' : '') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-hospital"></i>
              <p>
                {{ trans('menus.sidebar.item.unidades') }}

                @include('templates/parts/_sidebar__resource-marker', ['resource' => 'unidades'])

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('unidades.index') }}" class="nav-link {{ (Request::is('unidades') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('unidades') ? 'text-info' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.list') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('unidades.create') }}" class="nav-link {{ (Request::is('unidades/create') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('unidades/create') ? 'text-success' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.add') }}</p>
                </a>
              </li>

            </ul>
          </li>

        @endif

          <!-- Produtos -->

        @if(Auth::user()->hasRole('LAB') || Auth::user()->hasRole('GERENTE') || Auth::user()->hasRole('ADMIN'))

          <li class="nav-item has-treeview {{ (Request::is('produtos') || Request::is('produtos/*') ? 'menu-open' : '') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                {{ trans('menus.sidebar.item.produtos') }}

                @include('templates/parts/_sidebar__resource-marker', ['resource' => 'produtos'])

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('produtos.index') }}" class="nav-link {{ (Request::is('produtos') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('produtos') ? 'text-info' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.list') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('produtos.create') }}" class="nav-link {{ (Request::is('produtos/create') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('produtos/create') ? 'text-success' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.add') }}</p>
                </a>
              </li>

            </ul>
          </li>

        @endif

        <li class="nav-item">
          <a href="{{ route('vigilancia_epidemiologica.index') }}" class="nav-link">
            <i class="nav-icon fas fa-heartbeat"></i>
            <p>
              {{ trans('ve.relatorio') }}
            </p>
          </a>
        </li>

      </ul>

    </nav>
    <!-- /.Sidebar Menu -->

  </div>
  <!-- /.Sidebar -->

</aside>
