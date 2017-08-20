<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{route('dashboard')}}">
                <img src="#" width="30" height="30" class="d-inline-block align-top" alt="">
                Bazar
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @if(!Auth::user() && !Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user_login_page')}}">Login</a>
                        </li>
                    @endif
                    @if(Auth::user())
                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('orders')}}">Welcome {{Auth::user()->first_name}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user_logout')}}">Logout</a>
                        </li>
                    @endif
                    @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin_logout')}}">Admin Logout</a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav ml-auto">
                    @if(Auth::guard('admin')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Menu
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{route('admin_getUsers')}}">Admin Dashboard</a>
                                <a class="dropdown-item" href="{{route('admin_getCategories')}}">Mange Categories</a>
                                <a class="dropdown-item" href="{{route('admin_getItems')}}">Manage Items</a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('get_cart')}}">Cart <span class="badge badge-pill badge-primary">{{Session::has('cart') ? Session::get('cart')->totalQty : ''}}</span></a>
                        </li>
                    @endif
                </ul>
                <form class="form-inline my-2 my-lg-0" action="{{route('search')}}" method="GET">
                    <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>
