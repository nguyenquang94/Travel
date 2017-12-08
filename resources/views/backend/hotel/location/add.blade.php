@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_location')
btn-primary
@endsection

@section('html_title')
{{ isset($hotel) ? $hotel->name_vi : "Hotel" }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/hotel">Hotel</a></li>
    <li><a href="/hotel/{{ $hotel->id }}/edit">{{ $hotel->name_vi }}</a></li>
    <li>Location</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("hotel.add.title") }} 
            <span>> 
                {{ trans("general.add") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        @if (isset($hotel))
        @include("backend.hotel.sidebox")
        @endif
        <article class="col-md-9">
            @box_open(trans("hotel.add.title"))
                <div>
                    @if (isset($hotel))
                    {!! Form::open(["url" => "/hotel/$hotel->id", "method" => "put"]) !!}
                    @else
                    {!! Form::open(["url" => "/hotel", "method" => "post"]) !!}
                    @endif
                    <div class="widget-body">
                        <fieldset class="gllpLatlonPicker">
                            <div class="gllpMap" style="width: 100%; height: 400px;">Google Maps</div>
                            <input type="hidden" class="gllpLatitude" name="latitude" value="{{ $hotel->latitude }}"/>
                            <input type="hidden" class="gllpLongitude" name="longitude" value="{{ $hotel->longitude }}"/>
                            <input type="hidden" class="gllpZoom" value="5"/>
                        </fieldset>
                        {!! Form::hidden("places_ids", false) !!}
                        {!! Form::lbSelect2multi("place_ids[]", $hotel->places->pluck("id")->toArray(), App\Models\Place::toOption("name_vi"), "Place")!!}
                        <div class="widget-footer" style="text-align: left;">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection

@push('script')

<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="/js/jquery-gmaps-latlon-picker.js"></script>

@endpush

@push('css')
<link rel="stylesheet" type="text/css" href="/css/jquery-gmaps-latlon-picker.css"/>
@endpush