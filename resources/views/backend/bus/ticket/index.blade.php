@extends('app')

@section('sidemenu_bus')
active
@endsection

@section('sidebox_ticket')
btn-primary
@endsection

@section('html_title')
{{ $bus->name }} - Ticket
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/bus">Bus</a></li>
    <li>Ticket</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("bus.add.title") }} 
            <span>> 
                {{ trans("general.add") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        @if (isset($bus))
        @include("backend.bus.sidebox")
        @endif
        <article class="col-md-6">
            @box_open(trans("bus.add.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => "/ajax/bus/$bus->id/ticket",
                            'columns' => [
                                ['data' => 'price', 'title' => 'Price'],
                                ['data' => 'price_bwhere', 'title' => 'Price bwhere'],
                                ['data' => 'price_direct', 'title' => 'Price direct'],
                                ['data' => 'status', 'title' => 'Status'],
                                ['data' => 'created_at', 'title' => 'Created at', "hasFilter" => false],
                            ]
                        ])
                    </div>
                </div>
            @box_close
        </article>
        <article class="col-md-3">
            @box_open(trans("hotel.bus.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::open(["url" => "bus/$bus->id/trip", "method" => "POST"]) !!}
                        {!! Form::lbText("name_vi", null, "Name vi") !!}
                        {!! Form::lbText("name_en", null, "Name en") !!}
                        {!! Form::lbSelect2("type_id", null, $bus->types()->toOption("name"), "Type") !!}
                        {!! Form::lbSelect2("priceset_id", null, $bus->pricesets()->toOption("name"), "Type") !!}
                        {!! Form::lbText("num_ticket", null, "Number of ticket") !!}
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