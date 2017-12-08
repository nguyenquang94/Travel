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
    <li>Room type</li>
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
                            'url' => "/ajax/hotel/$hotel->id/roomtype",
                            'columns' => [
                                ['data' => 'name_vi', 'title' => 'Name vi'],
                                ['data' => 'name_en', 'title' => 'Name en'],
                                ['data' => 'rooms_count', 'title' => '# of rooms'],
                                ['data' => 'adult', 'title' => '# of adult'],
                                ['data' => 'child', 'title' => '# of child'],
                                ['data' => 'delete_button', 'title' => trans('general.action'), "hasFilter" => false],
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
                        {!! Form::open(["url" => "/hotel/$hotel->id/roomtype", "method" => "POST"]) !!}
                        {!! Form::lbText("name_vi", null, "Name vi") !!}
                        {!! Form::lbText("name_en", null, "Name en") !!}
                        {!! Form::lbText("adult", null, "Number of adult") !!}
                        {!! Form::lbText("child", null, "Number of child") !!}
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