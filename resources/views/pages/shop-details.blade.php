@extends('layouts.master')

@section('content')
<!-- Property Single Slider header -->
@php
$shop_id = $shop->id;
@endphp
<property-details-component :initial-shop="{{ $shop }}" :featured="{{$featured}}"></property-details-component>
<section class="osahan-slider">
    <div class="property-single-title property-single-title-gallery">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <h1>Shop in {{$shop->location}}</h1>
                    <h6><i class="mdi mdi-home-map-marker"></i> {{$shop->location}}</h6>
                </div>
                <div class="col-lg-4 col-md-4 text-right">
                    <h6 class="mt-2">{{$shop->status ===0 ?'Available':'Taken'}}</h6>
                    <h2 class="text-primary">Kshs. {{$shop->price}}
                        <small>/month</small>
                    </h2>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <p class="mt-1 mb-0"><strong>Property ID</strong> : {{$shop->id}} &nbsp;&nbsp; <strong>Add to
                            favorites</strong> <i class="mdi mdi-heart text-danger"></i></p>
                </div>
                <div class="col-lg-4 col-md-4 text-right">
                    <div class="footer-social">
                        <span>Share :</span> &nbsp;
                        <a class="btn-facebook" href="#"><i class="mdi mdi-facebook"></i></a>
                        <a class="btn-twitter" href="#"><i class="mdi mdi-twitter"></i></a>
                        <a class="btn-instagram" href="#"><i class="mdi mdi-instagram"></i></a>
                        <a class="btn-whatsapp" href="#"><i class="mdi mdi-whatsapp"></i></a>
                        <a class="btn-messenger" href="#"><i class="mdi mdi-facebook-messenger"></i></a>
                        <a class="btn-google" href="#"><i class="mdi mdi-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Property Single Slider header -->
<!-- Property Single Slider -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="card">
                    <div class="card-body osahan-slider pl-0 pr-0 pt-0 pb-0">
                        <img class="card-img-top" src="{{asset('uploads/shops/'.$shop->image.'')}}"
                            alt="Card image cap">
                    </div>
                </div>
                <div class="card padding-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Description</h5>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="list-icon">
                                    <i class="mdi mdi-move-resize-variant"></i>
                                    <strong>Size:</strong>
                                    <p class="mb-0">{{$shop->size}}</p>
                                </div>
                            </div>
                        </div>

                        <p>{{$shop->description}}</p>
                    </div>
                </div>

                @if($shop->status == 0)
                <div class="card padding-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">You'd like to take {{$shop->name}}?</h5>
                        <form name="sentMessage" method="post"
                            action="{{\App\Visit::hasVisitedShop($shop->id)?route('shop.visit'):route('shop.pay') }}">
                            <div class="row">
                                <div class="control-group form-group col-lg-4 col-md-4">
                                    <div class="controls">
                                        <input type="hidden" class="form-control" name="id" value="{{$shop->id}}"
                                            required>
                                        <input type="hidden" class="form-control" name="price" value="{{$shop->price}}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            @if(\App\Visit::hasVisitedShop($shop->id))
                            <button type="submit" class="btn btn-primary btn-lg">Pay for
                                Shop {{$shop->name}}</button>
                            <!-- data-toggle="modal" data-target="#Modal-overflow"-->
                            @else
                            <button type="submit" class="btn btn-primary btn-lg">Request a visit
                                to {{$shop->name}}</button>
                            @endif
                        </form>
                    </div>
                </div>

                @endif
                @if(auth()->check())
                <div class="card padding-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">You'd like to delete {{$shop->name}}?</h5>
                        <div class="row">
                            <div class="control-group form-group col-lg-4 col-md-4">
                                <div class="controls">
                                    <button type="submit" class="btn btn-primary btn-lg delete" data-id="{{$shop->id}}"
                                        data-url="{{route('shops.delete')}}"
                                        data-redirect="{{route('shops',['role'=>strtolower(user()->roles->first()->name)])}}">
                                        Delete {{$shop->name}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card sidebar-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Featured Shops</h5>
                        <div id="featured-properties" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($featured as $key=>$shop)
                                <li data-target="#featured-properties" data-slide-to="{{$key}}"
                                    class="{{$key ==0?'active':''}}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach($featured as $key=>$shop)
                                <div class="{{$key ==0?'carousel-item active':'carousel-item'}}">
                                    <div class="card card-list">
                                        <a href="{{route('shop.details',['id'=>$shop->id])}}">
                                            <div class="card-img">
                                                {{--<div class="love-badge text-danger"><i class="mdi mdi-heart-outline"></i></div>
                                                        <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 03</div>--}}
                                                @if($shop->status === 1)
                                                <span class="badge badge-success">Available</span>
                                                @else
                                                <span class="badge badge-info">Taken</span>
                                                @endif
                                                <img class="card-img-top"
                                                    src="{{asset('uploads/shops/'.$shop->image.'')}}"
                                                    alt="Card image cap">
                                            </div>
                                            <div class="card-body">
                                                <h2 class="text-primary mb-2 mt-0">
                                                    Kshs.{{$shop->price}}
                                                    <small>/month</small>
                                                </h2>
                                                <h5 class="card-title mb-2">{{$shop->location}}</h5>
                                                {{--<h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> Hope Street (Stop P), London SW11, UK</h6>--}}
                                            </div>
                                            <div class="card-footer">
                                                <span><i class="mdi mdi-move-resize-variant"></i> Size :
                                                    <strong>{{$shop->size}}</strong></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="app">
            <div class="modal fade" id="Modal-overflow" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title">Please Login To Continue</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="main" method="post" action="{{route('user.signin')}}" novalidate>
                            <div class="col-sm-12">
                                @csrf


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Email" required>
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
                                    <label class="col-sm-3"></label>
                                    <div class="col-sm-10">
                                        {{--<button type="submit" class="btn btn-primary m-b-0">Submit</button>--}}
                                        <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                        {{-- <submit action="Login" btncancel="Cancel"></submit> --}}
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="Visit-Modal-overflow" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" id="visit_modal_title">Title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="main" method="post" action="{{route('shop.requestvisit')}}" novalidate>
                            <div class="col-sm-12">
                                @csrf
                                <div class="input-group row">
                                    <label class="col-sm-3 col-form-label">Message</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="message" name="message" required></textarea>
                                        <span class="messages"></span>
                                    </div>
                                </div>

                                <div class="input-group row" id='datetimepicker1'>
                                    <label class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form_datetime" id="time" name="time"
                                            readonly required>
                                        <input type="hidden" class="form-control" id="id" name="id"
                                            value="{{$shop_id}}">
                                        <span class="messages"></span>
                                    </div>
                                </div>

                                {{--<div class="input-group date form_datetime col-md-5" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                                        <div class="col-sm-10">
                                            <label class="col-sm-3 col-form-label">Email</label>
                                            <input class="form-control" size="16" type="text" value="" readonly>
                                            --}}{{--<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>--}}{{--
                                        </div>
                                    </div>--}}
                                <div class="form-group row">
                                    <label class="col-sm-3"></label>
                                    <div class="col-sm-10" style="margin-top: 2%">
                                        {{--<button type="submit" class="btn btn-primary m-b-0">Submit</button>--}}
                                        <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                        {{-- <submit action="Request" btncancel="Cancel"></submit> --}}
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Property Single Slider -->
@endsection
@section('styles')
<link href="{{ asset('datepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">
<!-- Toastr, Sweet Alert Css -->
<link rel="stylesheet" href="{{asset('css/toastr.css')}}">
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
@endsection
@section('scripts')
<!--Vue-->
<script src="{{ asset('/js/vue/vue.js') }}"></script>{{----}}

<!--httpVueLoader-->
<script src="{{ asset('/js/vue/httpVueLoader.min.js') }}"></script>
<!--Main Script-->
<script src="{{ asset('/js/vue/main.js') }}"></script>

<!--Date Pickers-->

<script type="text/javascript" src="{{ asset('datepicker/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('datepicker/js/locales/bootstrap-datetimepicker.fr.js') }}"
    charset="UTF-8"></script>
<!-- Jquery DataTable Plugin Js -->
<script type="text/javascript" src="{{ asset('js/toastr.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>

<script>
    $(document).ready(function () {
            /*$('.form_datetime').datetimepicker({
                //language:  'fr',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1
            });*/
            $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
            $('button[type=submit]').on('click', function (e) {
                    e.preventDefault();
                    post(e);
                }
            )
            var post = function (e) {
                var form = $(e.target).parent().closest('form');
                form.find("input").filter(':disabled').removeAttr('disabled');
                var url = form.attr('action');
                //var input = JSON.stringify(form.serializeArray());
                //var input = form.serialize();
                var input = new FormData(form[0]);
                const config = {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }

                axios.post(url, input, config)

                    .then(function (response) {


                        //form.trigger('reset')
                        //call method, refresh table data
                        //this.$root.$emit('submitted') //like this
                        var results = response.data.data;
                        if (!results.auth) {
                            $('#Modal-overflow').modal('show')
                        } else {
                            $('#Visit-Modal-overflow').modal('show')
                            $('#visit_modal_title').text(results.message)
                        }

                        if (results.success) {

                        }


                    })

                    .catch(function (error) {

                        this.name = error;

                    });
            }

            $('.delete').on('click', function () {
                var id = $(this).data('id');
                var url = $(this).data('url');
                var redirect = $(this).data('redirect');
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
                    window.location.href = redirect;
                });

            })
        });
</script>
@endsection
