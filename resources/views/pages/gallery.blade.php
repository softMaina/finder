@extends('layouts.master')

@section('content')
    <!-- Main Slider With Form -->
    <section class="osahan-slider">
        <div id="osahanslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#osahanslider" data-slide-to="0" class="active"></li>
                <li data-target="#osahanslider" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active slider-one">
                    <div class="overlay"></div>
                </div>
                <div class="carousel-item slider-two">
                    <div class="overlay"></div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#osahanslider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#osahanslider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </section>
    <!-- End Main Slider With Form -->
    <!-- Properties List -->
    <section class="section-padding">
        <div class="section-title text-center mb-5">
            <h2>Gallery</h2>
            {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>--}}
        </div>
        <div class="container">
            <div class="row" id="shops_row">

                @foreach($shops as $shop)

                    <div class="col-lg-4 col-md-4">
                        <div class="card card-list">
                            <a class="thumbnail fancybox" rel="ligthbox"
                               href="{{asset('uploads/shops/'.$shop->image.'')}}">
                                <div class="card-img">
                                    -->
                                    <img class="card-img-top img-responsive"
                                         src="{{asset('uploads/shops/'.$shop->image.'')}}" alt="Card image cap">
                                </div>
                                <div class="card-body">
                                    <h2 class="text-primary mb-2 mt-0">
                                        KShs. {{$shop->price}}
                                        <small>/Per Month</small>
                                    </h2>
                                    <h5 class="card-title mb-2">Shop in {{$shop->location}}</h5>
                                    <h6 class="card-subtitle mt-1 mb-0 text-muted"><i
                                            class="mdi mdi-home-map-marker"></i> {{$shop->name}}</h6>
                                </div>
                                <div class="card-footer">
                                    <span><i
                                            class="mdi mdi-move-resize-variant"></i> Size : <strong>{{$shop->size}}</strong></span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{--<div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="card card-list">
                        <a href="#">
                            <div class="card-img">
                                <div class="love-badge text-danger"><i class="mdi mdi-heart-outline"></i></div>
                                <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 18</div>
                                <span class="badge badge-danger">For Sale</span>
                                <img class="card-img-top" src="{{asset('templates/osahan-property/img/list/4.png')}}" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h2 class="text-primary mb-2 mt-0">
                                    $25,000 <small>/month</small>
                                </h2>
                                <h5 class="card-title mb-2">Store Space Greenville</h5>
                                <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> 250-260 3rd St, Hoboken, NJ 07030, USA</h6>
                            </div>
                            <div class="card-footer">
                                <span><i class="mdi mdi-sofa"></i> Beds : <strong>6</strong></span>
                                <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>4</strong></span>
                                <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>987 sq ft</strong></span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-list">
                        <a href="#">
                            <div class="card-img">
                                <div class="love-badge text-danger"><i class="mdi mdi-heart"></i></div>
                                <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 04</div>
                                <span class="badge badge-warning">For Rent</span>
                                <img class="card-img-top" src="{{asset('templates/osahan-property/img/list/5.png')}}" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h2 class="text-primary mb-2 mt-0">
                                    $12,000 <small>/month</small>
                                </h2>
                                <h5 class="card-title mb-2">Villa in Melbourne</h5>
                                <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> NJ 07305, USA</h6>
                            </div>
                            <div class="card-footer">
                                <span><i class="mdi mdi-sofa"></i> Beds : <strong>8</strong></span>
                                <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>4</strong></span>
                                <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>120 sq ft</strong></span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-list">
                        <a href="#">
                            <div class="card-img">
                                <div class="love-badge text-danger"><i class="mdi mdi-heart-outline"></i></div>
                                <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 45</div>
                                <span class="badge badge-info">For Rent</span>
                                <img class="card-img-top" src="{{asset('templates/osahan-property/img/list/6.png')}}" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h2 class="text-primary mb-2 mt-0">
                                    $356, 000 <small>/month</small>
                                </h2>
                                <h5 class="card-title mb-2">Villa on Hollywood Boulev</h5>
                                <h6 class="card-subtitle mt-1 mb-0 text-muted"><i class="mdi mdi-home-map-marker"></i> The Village, Jersey City, NJ 07302, USA</h6>
                            </div>
                            <div class="card-footer">
                                <span><i class="mdi mdi-sofa"></i> Beds : <strong>1</strong></span>
                                <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>3</strong></span>
                                <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>187 sq ft</strong></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>--}}
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button class="btn btn-secondary font-weight-bold btn-lg" type="submit">VIEW ALL</button>
                </div>
            </div>
        </div>
    </section>
    <!-- End Properties List -->
    <!-- Properties by City -->

    <!-- End Properties by City -->
    <!-- Trusted Agents -->

    <!-- End Trusted Agents -->
    <!-- Blog -->

    <!-- End Blog -->
    <!-- Join Team -->

    <!-- End Join Team -->
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css')}}"
          media="screen">
@endsection
@section('scripts')
    <script src="{{asset('//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js')}}"></script>
    <!-- Other -->
    <script>
        $(document).ready(function () {
            /*======================*/
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            /*=====================*/
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

                        var results = response.data;
                        if (response.headers['content-type'].indexOf('text/html') >= 0) {

                            var shops_row = $('#shops_row');
                            shops_row.html(results);

                            form.trigger('reset');
                            //toastr.success(' Posted')
                            //toastr.options.timeOut = 3000; // 3s
                        } else {
                            toastr.error(results)
                            toastr.options.timeOut = 3000; // 3s
                        }

                    })

                    .catch(function (error) {

                        this.name = error;

                    });
            }
        });
    </script>
@endsection
