@extends('backend.layouts.master')

@section('content')
<div id="app">
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Visits
                        {{--<small>Welcome to {{ config('app.name') }}</small>--}}
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i>
                                {{ config('app.name') }}</li>
                        <li class="breadcrumb-item"></li>
                        <li class="breadcrumb-item active">Visits</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header" style="display: none">
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
                                @if(Auth::user()->hasRole('Landlord'))
                                <button type="button" class="btn btn-success waves-effect m-r-20" data-toggle="modal"
                                    data-target="#Modal-overflow">Add New
                                </button>
                                @endif
                            </div>
                            @if(!\App\Visit::hasVisits() || user()->visits()->count()==0)
                            <div class="card-header" style="margin-top: 10%;">
                                <p class="text-center">No Visits Yet</p>
                            </div>
                            @endif
                            @if(Auth::user()->hasRole('Tenant'))
                            <div>
                                <vuetable url="{{route('user.visits')}}" view_url="{{ request()->root().'/shop/' }}"
                                    titles="Name,Lacation,Visiting_Date" data="name,location,visiting_time"
                                    action="View" ctitle="Action" has_category="false"
                                    categories="New,Entertainment,New Skill,Adventure,Sporting,Marine,Nature"
                                    has_image="false" image_key="idea_image" update_header="Update Entry" akey="id">
                                </vuetable>
                            </div>

                            @endif
                            @if(Auth::user()->hasRole('Admin'))
                            <div>
                                <vuetable url="{{route('user.visits')}}" view_url="{{ request()->root().'/shop/' }}"
                                    titles="Name,Lacation,Visiting_Date" data="name,location,visiting_time"
                                    action="View" ctitle="Action" has_category="false"
                                    categories="New,Entertainment,New Skill,Adventure,Sporting,Marine,Nature"
                                    has_image="false" image_key="idea_image" update_header="Update Entry" akey="id">
                                </vuetable>
                            </div>
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
                <form id="main" method="post" action="{{route('shops.create')}}" novalidate>
                    <div class="col-sm-12">
                        <!-- Basic Inputs Validation start -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea rows="2" cols="5" class="form-control" id="description" name="description"
                                    placeholder="Description"></textarea>
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="location" name="location"
                                    placeholder="Location">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                                <span class="messages"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Size</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="size" name="size" placeholder="Size">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="image" name="image"
                                    enctype="multipart/form-data">
                                <span class="messages"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2"></label>
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
