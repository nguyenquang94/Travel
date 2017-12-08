@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_room')
btn-primary
@endsection

@section('html_title')
{{ isset($hotel) ? $hotel->name_vi : "Hotel" }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/hotel">Hotel</a></li>
    <li><a href="/hotel/{{ $hotel->id }}/edit">{{ $hotel->name_vi }}</a></li>
    <li>Rooms</li>
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
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => "/ajax/hotel/$hotel->id/room",
                            'columns' => [
                                ['data' => 'name_vi', 'title' => 'Name vi'],
                                ['data' => 'name_en', 'title' => 'Name en'],
                                ['data' => 'roomtype.name_vi', 'title' => 'Room type'],
                                ['data' => 'area.name_vi', 'title' => 'Area'],
                                ['data' => 'edit_button', 'title' => 'Edit', "hasFilter" => false],
                                ['data' => 'delete_button', 'title' => 'Delete', "hasFilter" => false],
                            ]
                        ])
                    </div>
                </div>
            @box_close
        </article>
        <article class="col-md-3">
            @box_open(trans("hotel.add.title"))
                <div>
                    <div class="widget-body">
                        @if (isset($room))
                        {!! Form::open(["url" => "/hotel/$hotel->id/room/$room->id", "method" => "PUT"]) !!}
                        @else
                        {!! Form::open(["url" => "/hotel/$hotel->id/room", "method" => "POST"]) !!}
                        @endif
                        {!! Form::lbText("name_vi", @$room->name_vi, "Name vi") !!}
                        {!! Form::lbText("name_en", @$room->name_en, "Name en") !!}
                        {!! Form::lbSelect("room_type_id", @$room->room_type_id, $hotel->roomtypes()->toOption("name_vi"), "Room type") !!}
                        {!! Form::lbSelect("area_id", @$room->area_id, $hotel->areas()->toOption("name_vi"), "Room type") !!}
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