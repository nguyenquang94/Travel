@extends('app')

@section('sidemenu_system_balance')
active
@endsection

@section('html_title')
Toạ độ {{ $place->name_vi }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>System</li>
    <li>Balance</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                Điều chỉnh toạ độ {{ $place->name_vi }}
        </h1>
    </div>
    @include("backend.header_chart")
</div>

<section id="widget-grid" class="">
    <div class="row">
        {!! Form::open(["url" => "/place/$place->id", "method" => "put"]) !!}
        <article class="col-md-9">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body">
                        <div id="map" style="height: 500px; width: 100%;"></div>
                    </div>
                </div>
            @box_close
        </article>
        <article class="col-md-3">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::lbText("latitude", $place->latitude ? $place->latitude : "21.007738", "Latitude") !!}
                        {!! Form::lbText("longitude", $place->longitude ? $place->longitude : "105.827187", "longitude") !!}
                        {!! Form::lbText("address_en", @$place->address_en, "address_en") !!}
                        {!! Form::lbText("address_vi", @$place->address_vi, "address_vi") !!}
                        {!! Form::lbText("zoom", $place->zoom ? $place->zoom : 5, "zoom") !!}
                        <div class="widget-footer">
                            {{ Form::lbSubmit() }}
                        </div>
                    </div>
                </div>
            @box_close
        </article>
        {!! Form::close() !!}
    </div>
</section>

@endsection

@push('script')
<script>
    function initMap() {
        var location = {lat: {{ $place->latitude ? $place->latitude : "21.007738" }}, lng: {{ $place->longitude ? $place->longitude : "105.827187" }}};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: {{ $place->zoom ? $place->zoom : 5 }},
            center: location
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true,
        });
        google.maps.event.addListener(marker, 'drag', function(event) {
            $('input[name=latitude]').val(this.position.lat());
            $('input[name=longitude]').val(this.position.lng());
        });

        map.addListener('zoom_changed', function() {
            $('input[name=zoom]').val(this.zoom);
        });
      }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
@endpush
