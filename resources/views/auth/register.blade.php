@extends('auth.master')

@section('content')
    <div class="page-header">
        <div class="page-header-image" style="background-image:url({{asset('templates/oreo/assets/images/login.jpg')}})"></div>
        <div class="container">
            <div class="col-md-12 content-center">
                <div class="card-plain">
                    <form class="form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="header">
                            <div class="logo-container">
                                <img src="{{asset('templates/oreo/assets/images/logo.svg')}}" alt="">
                            </div>
                            <h5>Sign Up</h5>
                            <span>Register a new membership</span>
                        </div>
                        <div class="content">
                            <div class="input-group">
                                <input id="firstname" type="text"
                                       class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                       name="firstname" value="{{ old('firstname') }}" placeholder="First Name" required autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                                <span class="input-group-addon">
                                <i class="zmdi zmdi-account-circle"></i>
                            </span>
                            </div>
                            <div class="input-group">
                                <input id="lastname" type="text"
                                       class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                       name="lastname" value="{{ old('lastname') }}" placeholder="Last Name" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                                <span class="input-group-addon">
                                <i class="zmdi zmdi-account-circle"></i>
                            </span>
                            </div>
                            <div class="input-group">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" value="{{ old('email') }}" placeholder="Email" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <span class="input-group-addon">
                                <i class="zmdi zmdi-email"></i>
                            </span>
                            </div>
                            <div class="input-group">
                                <input id="phone_number" type="text"
                                       class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                       name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number" required autofocus>

                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                                <span class="input-group-addon">
                                <i class="zmdi zmdi-phone"></i>
                            </span>
                            </div>
                            <div class="input-group">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <span class="input-group-addon">
                                <i class="zmdi zmdi-lock"></i>
                            </span>
                            </div>
                            <div class="input-group">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password_confirmation" placeholder="Confirm Password" required>


                                <span class="input-group-addon">
                                <i class="zmdi zmdi-lock"></i>
                            </span>
                            </div>
                            <div class="input-group">
                                <select class="form-control" name="role">
                                    <option selected>Select</option>
                                    <option value="2">Tenant</option>
                                    <option value="3">Landlord</option>
                                </select>


                                <span class="input-group-addon">
                                <i class="zmdi zmdi-account-box"></i>
                            </span>
                            </div>
                        </div>
                        <div class="checkbox">
                            <input id="terms" type="checkbox">
                            <label for="terms">
                                I read and agree to the <a href="javascript:void(0);">terms of usage</a>
                            </label>
                        </div>
                        <div class="footer text-center">
                            <button type="submit"
                                    class="btn btn-primary btn-round btn-lg btn-block waves-effect waves-light">SIGN UP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav>
                    <ul>
                        <li><a href="#" target="_blank">Contact Us</a></li>
                        <li><a href="#" target="_blank">About Us</a></li>
                        <li><a href="javascript:void(0);">FAQ</a></li>
                    </ul>
                </nav>
                <div class="copyright">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('authbutton')
    <li class="nav-item">
        <a class="nav-link btn btn-white btn-round" href="{{route('login')}}">SIGN IN</a>
    </li>
@endsection
