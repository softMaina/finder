@foreach($shops as $shop)

    <div class="col-lg-4 col-md-4">
        <div class="card card-list">
            <a href="#">
                <div class="card-img">
                    <div class="love-badge text-danger"><i class="mdi mdi-heart"></i></div>
                    <div class="badge images-badge"><i class="mdi mdi-image-filter"></i> 12</div>
                    <span class="badge badge-primary">{{$shop->location === 0 ?'Available':'Taken'}}</span>
                    <img class="card-img-top" src="{{asset('uploads/shops/'.$shop->image.'')}}" alt="Card image cap">
                </div>
                <div class="card-body">
                    <h2 class="text-primary mb-2 mt-0">
                        KShs. {{$shop->price}}
                        <small>/Per Month</small>
                    </h2>
                    <h5 class="card-title mb-2">Shop in {{$shop->location}}</h5>
                    <h6 class="card-subtitle mt-1 mb-0 text-muted"><i
                            class="mdi mdi-home-map-marker"></i> {{$shop->location}}</h6>
                </div>
                {{--<div class="card-footer">
                    <span><i class="mdi mdi-sofa"></i> Beds : <strong>3</strong></span>
                    <span><i class="mdi mdi-scale-bathroom"></i> Baths : <strong>2</strong></span>
                    <span><i class="mdi mdi-move-resize-variant"></i> Area : <strong>587 sq ft</strong></span>
                </div>--}}
            </a>
        </div>
    </div>
@endforeach
