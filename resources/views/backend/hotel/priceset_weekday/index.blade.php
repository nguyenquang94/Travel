@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_priceset_weekday')
btn-primary
@endsection

@section('html_title')
{{ isset($hotel) ? $hotel->name_vi : "Hotel" }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/hotel">Hotel</a></li>
    <li><a href="/hotel/{{ $hotel->id }}/edit">{{ $hotel->name_vi }}</a></li>
    <li>Priceset Weekday</li>
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
                            'url' => "/ajax/hotel/$hotel->id/priceset_weekday",
                            'columns' => [
                                ['data' => 'name_vi', 'title' => 'Name vi'],
                                ['data' => 'start_date', 'title' => 'Start date'],
                                ['data' => 'monday_priceset.name_vi', 'title' => 'Monday'],
                                ['data' => 'tuesday_priceset.name_vi', 'title' => 'Tuesday'],
                                ['data' => 'wednesday_priceset.name_vi', 'title' => 'Wednesday'],
                                ['data' => 'thursday_priceset.name_vi', 'title' => 'Thursday'],
                                ['data' => 'friday_priceset.name_vi', 'title' => 'Friday'],
                                ['data' => 'saturday_priceset.name_vi', 'title' => 'Saturday'],
                                ['data' => 'sunday_priceset.name_vi', 'title' => 'Sunday']
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
                        {!! Form::open(["url" => "/hotel/$hotel->id/priceset_weekday", "method" => "POST"]) !!}
                        {!! Form::lbText("name_vi", null, "Name vi") !!}
                        {!! Form::lbText("name_en", null, "Name en") !!}
                        {!! Form::lbDatepicker("start_date", null, "Start date") !!}
                        {!! Form::lbSelect("monday_priceset_id", null, $hotel->pricesets()->toOption("name_vi"), "Monday Priceset") !!}
                        {!! Form::lbSelect("tuesday_priceset_id", null, $hotel->pricesets()->toOption("name_vi"), "Tuesday Priceset") !!}
                        {!! Form::lbSelect("wednesday_priceset_id", null, $hotel->pricesets()->toOption("name_vi"), "Wednesday Priceset") !!}
                        {!! Form::lbSelect("thursday_priceset_id", null, $hotel->pricesets()->toOption("name_vi"), "Thursday Priceset") !!}
                        {!! Form::lbSelect("friday_priceset_id", null, $hotel->pricesets()->toOption("name_vi"), "Friday Priceset") !!}
                        {!! Form::lbSelect("saturday_priceset_id", null, $hotel->pricesets()->toOption("name_vi"), "Saturday Priceset") !!}
                        {!! Form::lbSelect("sunday_priceset_id", null, $hotel->pricesets()->toOption("name_vi"), "Sunday Priceset") !!}
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