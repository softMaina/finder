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
    <div class="slider-form">
        <div class="container">
            <h2 class="text-left mb-5">Find Your Preferred Shop</h2>
            <search-component :shop-sizes="{{ $shopSizes }}" :property-types="{{ $propertyTypes }}"></search-component>
        </div>
    </div>
</section>
<!-- End Main Slider With Form -->
<!-- Properties List -->
<section class="section-padding">
    <div class="section-title text-center mb-5">
        <h2>Latest Shops</h2>
    </div>
    @if (Auth::check())
    <properties-component :shops="{{ $shops->toJson() }}" :is-logged-in="true"></properties-component>
    @else
    <properties-component :shops="{{ $shops->toJson() }}" :is-logged-in="false"></properties-component>
    @endif
</section>
@endsection

@section('scripts')
<!-- Other -->
<script>
    $(document).ready(function () {
            /*======================*/
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });
        });
</script>
@endsection
