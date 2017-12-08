@extends('app')

@section('sidemenu_bus')
active
@endsection

@section('sidebox_priceset')
btn-primary
@endsection

@section('html_title')
{{ $bus->name }} - Priceset
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/bus">Bus</a></li>
    <li>Priceset</li>
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
                            'url' => "/ajax/bus/$bus->id/priceset",
                            'columns' => [
                                ['data' => 'name_vi', 'title' => 'Name vi'],
                                ['data' => 'name_en', 'title' => 'Name en'],
                                ['data' => 'price', 'title' => 'Price'],
                                ['data' => 'price_bwhere', 'title' => 'Price BWhere'],
                                ['data' => 'price_direct', 'title' => 'Price Direct'],
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
                        {!! Form::open(["url" => "bus/$bus->id/priceset", "method" => "POST"]) !!}
                        {!! Form::lbText("name_vi", null, "Name vi") !!}
                        {!! Form::lbText("name_en", null, "Name en") !!}
                        {!! Form::lbText("price", null, "Price") !!}
                        {!! Form::lbText("price_bwhere", null, "Price BWhere") !!}
                        {!! Form::lbText("price_direct", null, "Price Direct") !!}
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