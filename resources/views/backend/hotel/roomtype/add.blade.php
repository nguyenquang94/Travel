@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_room_type')
btn-primary
@endsection

@section('html_title')
{{ isset($hotel) ? $hotel->name_vi : "Hotel" }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/hotel">Hotel</a></li>
    <li><a href="/hotel/{{ $hotel->id }}/edit">{{ $hotel->name_vi }}</a></li>
    <li><a href="/hotel/{{ $hotel->id }}/roomtype">Room types</a></li>
    <li>{{ $room_type->name_en }}</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("hotel.add.title") }} 
            <span>
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
        <article class="col-md-6">
            @box_open(trans("hotel.add.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::open(["url" => "/hotel/$hotel->id/roomtype/$room_type->id", "method" => "PUT"]) !!}
                        {!! Form::lbText("name_vi", $room_type->name_vi, "Name vi") !!}
                        {!! Form::lbText("name_en", $room_type->name_en, "Name en") !!}
                        {!! Form::lbText("adult", $room_type->adult, "Number of adult") !!}
                        {!! Form::lbText("child", $room_type->child, "Number of child") !!}
                        <div class="widget-footer" style="text-align: left;">
                            {!! Form::lbSubmit() !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection