<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand text-success logo" href="{{route('index')}}">
                <img src="{{asset('templates/osahan-property/img/logo.png')}}" alt="osahan logo">
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('index')}}">
                            HOME
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#">
                            About Us
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('gallery')}}">
                            GALLERY
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#">
                            Contact Us
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#">
                            FAQ
                        </a>
                    </li>
                </ul>
                <div class="my-2 my-lg-0">
                    <ul class="list-inline main-nav-right">
                        @if(auth()->check())
                            <li class="list-inline-item">
                                <a class="btn btn btn-outline-primary btn-sm"
                                   href="{{route('dashboard',['role'=> Auth::user()->hasRole('writer')])}}"><i
                                        class="mdi mdi-account-outline"></i> Dashboard</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn btn-outline-primary btn-sm"
                                onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();"><i
                                        class="mdi mdi-account-outline"></i> Log Out</a>
                                <form id="logout-form-2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="list-inline-item">
                                <a class="btn btn btn-outline-primary btn-sm" href="{{route('login')}}"><i
                                        class="mdi mdi-account-outline"></i> Sign In</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-primary btn-sm" href="{{route('register')}}"><i
                                        class="mdi mdi-security-account"></i> Sign Up</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
