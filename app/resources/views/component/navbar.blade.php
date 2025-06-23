
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <span class="brand-text font-weight-bold text-danger"><img src="{{ asset('rinnai.svg') }}" style="height: 25px;"></span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ url('/')}}" class="nav-link {{ Request::is('/') ? 'active' : ''}}">Home</a>
                </li>
                @canany([\App\Rules::AdminSales->value,\App\Rules::Administrator->value,\App\Rules::AdminWarehouse->value])

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('Transaction*') ? 'active' : '' }}" href="#" id="transactionDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Transaction
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="transactionDropdown">
                        @canany([\App\Rules::AdminSales->value,\App\Rules::Administrator->value])
                        <li>
                            <a class="dropdown-item" href="{{ route('transaction.index') }}">Upload Data Planning</a>
                        </li>
                        @endcanany
                         @canany([\App\Rules::AdminWarehouse->value,\App\Rules::Administrator->value])
                          <li>
                            <a class="dropdown-item" href="{{ route('transaction.view') }}">Data Planning</a>
                        </li>
                         @endcanany
                    </ul>
                </li>
                @endcanany
                @canany([\App\Rules::Checker1->value,\App\Rules::Administrator->value,\App\Rules::AdminWarehouse->value])
                <li class="nav-item">
                    <a href="{{ route('checker.index') }}" class="nav-link {{ Request::is('Checker-1*') ? 'active' : ''}}">Checker 1</a>
                </li>
                @endcanany
                @canany([\App\Rules::Checker2->value,\App\Rules::Administrator->value])

                <li class="nav-item">
                    <a href="{{ route('checkertwo.index') }}" class="nav-link {{ Request::is('Checker-2*') ? 'active' : ''}}">Checker 2</a>
                </li>
                @endcanany
                @canany([\App\Rules::Checker3->value,\App\Rules::Administrator->value])

                <li class="nav-item">
                    <a href="{{ route('checkerthree.index') }}" class="nav-link {{ Request::is('Checker-3*') ? 'active' : ''}}">Checker 3</a>
                </li>
                @endcanany
            </ul>
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a href="{{route('login')}}" class="nav-link brand-text font-weight-bold text-primary">
                        <i class="fa fa-cloud" aria-hidden="true"></i> Sign-in</a>
                </li>
                @endguest
                @auth
                    <li class="nav-item row">
                        @canany([\App\Rules::AdminSales->value,\App\Rules::Administrator->value,\App\Rules::Supervisor->value])

                        <a href="{{route('admin.index')}}" class="nav-link brand-text font-weight-bold text-primary">
                            <i class="fa fa-cloud" aria-hidden="true"></i> Dashboard</a> |
                        @endcanany
                        <a href="{{route('logout')}}" class="nav-link brand-text font-weight-bold text-danger d-flex align-items-baseline" style="gap: 4px">
                            <i class="nav-icon fas fa-share-square"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>

    </div>
</nav>
