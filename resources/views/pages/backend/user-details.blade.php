@extends('backend.layouts.master')

@section('content')
    <section class="content profile-page">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>
                        <small>Welcome to {{config('app.name')}}</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">

                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('dashboard',['role'=>strtolower($user->roles->first()->name)])}}"><i
                                    class="zmdi zmdi-home"></i> {{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xl-12 col-lg-7 col-md-12">
                    <div class="card profile-header">
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="profile-image float-md-right"><img
                                            src="{{asset('uploads/avatars/'.$user->avatar.'')}}" alt=""></div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-12">
                                    <h4 class="m-t-0 m-b-0"><strong>{{$user->firstname}}</strong> {{$user->lastname}}
                                    </h4>
                                    <span class="job_post">{{$user->roles->first()->name}}</span>

                                    <p class="social-icon m-t-5 m-b-0">
                                        <a title="Twitter" href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a>
                                        <a title="Facebook" href="javascript:void(0);"><i
                                                class="zmdi zmdi-facebook"></i></a>
                                        <a title="Google-plus" href="javascript:void(0);"><i
                                                class="zmdi zmdi-twitter"></i></a>
                                        <a title="Behance" href="javascript:void(0);"><i class="zmdi zmdi-behance"></i></a>
                                        <a title="Instagram" href="javascript:void(0);"><i
                                                class="zmdi zmdi-instagram "></i></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="profile.html#about">About</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="profile.html#friends">Friends</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="app">
                            <div class="tab-pane body active" id="about">
                                <form id="main" method="post" action="{{route('user.update')}}" novalidate>
                                    <div class="col-sm-12">
                                        <!-- Basic Inputs Validation start -->

                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">First Name</label>
                                            <div class="col-sm-12">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->id}}" required>
                                                <input type="hidden" class="form-control" id="is_user" name="is_user" value="{{$user->id}}" required>
                                                <input type="text" class="form-control" id="firstname"
                                                       name="firstname" placeholder="{{$user->firstname}}" required>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Last Name</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="lastname"
                                                       name="lastname" placeholder="{{$user->lastname}}" required>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Email</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="email"
                                                       name="email" placeholder="{{$user->email}}" required>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Password</label>
                                            <div class="col-sm-12">
                                                @php
                                                    $array = str_split($user->getAuthPassword());
                                                    $str = '';
                                                   foreach ($array as $char) {
                                                       $str.='*';
                                                   }
                                                @endphp
                                                <input type="password" class="form-control" id="password"
                                                       name="password" placeholder="******" required>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Phone Number</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="phone_number"
                                                       name="phone_number" placeholder="{{$user->phone_number}}"
                                                       required>
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Avatar</label>
                                            <div class="col-sm-12">
                                                <input type="file" class="form-control" id="avatar"
                                                       name="avatar" enctype="multipart/form-data">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12"></label>
                                            <div class="col-sm-12">
                                                {{--<button type="submit" class="btn btn-primary m-b-0">Submit</button>--}}
                                                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                                <submit action="Update" btncancel="Clear"></submit>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <button class="btn btn-danger btn-icon btn-round hidden-sm-down float-right ml-3 delete"
                                        type="button"
                                        data-id="{{$user->id}}" data-url="{{route('user.delete')}}">
                                    <a style="cursor: pointer" title="Delete {{$user->firstname}}"><i
                                            class="zmdi zmdi-delete"></i></a>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                {{--<div class="col-lg-8 col-md-12">
                    <div class="card">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="profile.html#mypost">My Post</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="profile.html#timeline">Timeline</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="profile.html#usersettings">Setting</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="mypost">
                            <div class="card">
                                <div class="body">
                                    <div class="form-group">
                                        <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                    </div>
                                    <div class="post-toolbar-b">
                                        <button class="btn btn-warning btn-icon  btn-icon-mini btn-round"><i class="zmdi zmdi-attachment"></i></button>
                                        <button class="btn btn-warning btn-icon  btn-icon-mini btn-round"><i class="zmdi zmdi-camera"></i></button>
                                        <button class="btn btn-primary btn-round">Post</button>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>--}}
            </div>
        </div>
    </section>
@endsection
@section('styles')
    <!-- Toastr, Sweet Alert Css -->
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
@endsection

@section('scripts')
    <!-- Custom Js -->
    <script type="text/javascript" src="{{ asset('js/toastr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script>
        $(function () {
            $('.delete').on('click', function () {
                var id = $(this).data('id');
                var url = $(this).data('url');
                swal({
                    title: '<strong style="color: #ffffff">Are you sure?</strong>',
                    html: '<strong style="color: #ffffff">You will not recover this user</strong>',
                    type: 'warning',
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonClass: 'btn btn-light',
                    background: 'rgba(0,0,0,.5)'
                }).then(function () {

                    axios.post(url,
                        {id: id}
                    ).then(function (response) {
                        var result = response.data.data;
                        //alert(JSON.stringify(result))
                        if (result.success) {
                            toastr.success(result.message)
                            toastr.options.timeOut = 3000;
                        } else {
                            toastr.error(results.message)
                            toastr.options.timeOut = 3000;
                        }

                    })
                        .catch(function (error) {

                            this.name = error;

                        });

                    swal({
                        title: '<strong style="color: #ffffff">Done!</strong>',
                        html: '<strong style="color: #ffffff">User Deleted</strong>',
                        type: 'success',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-light',
                        background: 'rgba(0,0,0,.5)'
                    });
                    // redirect
                    window.location.href = domain + 'admin/users';
                });

            })

        })
    </script>
@endsection
