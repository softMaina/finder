@extends('backend.layouts.master')

@section('content')
<div id="app">
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Tenants
                        {{--<small>Welcome to {{ config('app.name') }}</small>--}}
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i>
                                {{ config('app.name') }}</li>
                        <li class="breadcrumb-item"></li>
                        <li class="breadcrumb-item active">Tenants</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header" style="display: none;">
                            <h2><strong></strong></h2>
                            <ul class="header-dropdown">
                                <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp float-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="card-header">
                                @if(user()->hasRole('Admin'))
                                <button type="button" class="btn btn-success waves-effect m-r-20" data-toggle="modal"
                                    data-target="#Modal-overflow">Add New
                                </button>
                                @endif
                            </div>
                            @if(Auth::user()->hasRole('Admin'))
                            <vuetable url="{{route('user.tenants')}}" update_url="{{route('user.update')}}"
                                delete_url="{{route('user.delete')}}" view_url="{{ request()->root().'/user/' }}"
                                titles="Firstname,lastname,Email" data="firstname,lastname,email" action="View"
                                ctitle="Action" has_category="false"
                                categories="New,Entertainment,New Skill,Adventure,Sporting,Marine,Nature"
                                has_image="false" image_key="idea_image" update_header="Update Entry" akey="id">
                            </vuetable>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->

        </div>

    </section>
    <!-- Modal -->


    <div class="modal fade" id="Modal-overflow" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="main" method="post" action="{{route('user.create')}}" novalidate>
                    <div class="col-sm-12">
                        <!-- Basic Inputs Validation start -->

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    placeholder="First Name" required>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    placeholder="Last Name" required>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="Phone Number" required>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Avatar</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="avatar" name="avatar"
                                    enctype="multipart/form-data">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <select id="role" name="role">
                                    @foreach(\App\Role::get() as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3"></label>
                            <div class="col-sm-10">
                                {{--<button type="submit" class="btn btn-primary m-b-0">Submit</button>--}}
                                <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                <submit action="Add" btncancel="Clear"></submit>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- JQuery DataTable Css -->
<link rel="stylesheet" href="{{asset('templates/oreo/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('css/toastr.css')}}">
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
@endsection

@section('scripts')
<!-- Jquery DataTable Plugin Js -->
<script src="{{asset('templates/oreo/light/assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('templates/oreo/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('templates/oreo/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('templates/oreo/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('templates/oreo/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('templates/oreo/assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>

{{--<script src="{{asset('templates/oreo/light/assets/bundles/mainscripts.bundle.js')}}"></script>--}}
<!-- Custom Js -->
<script src="{{asset('templates/oreo/light/assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/toastr.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
