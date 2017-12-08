@extends('app')

@section('sidemenu_bus')
active
@endsection

@section('sidebox_trip')
btn-primary
@endsection

@section('html_title')
{{ $bus->name }} - Trip
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/bus">Bus</a></li>
    <li>Trip</li>
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
                            'url' => "/ajax/bus/$bus->id/trip",
                            'columns' => [
                                ['data' => 'type.name_vi', 'title' => 'Type'],
                                ['data' => 'priceset.name_vi', 'title' => 'Priceset'],
                                ['data' => 'start_date', 'title' => 'Start date'],
                                ['data' => 'start_time', 'title' => 'Start date'],
                                ['data' => 'eta_date', 'title' => 'ETA date'],
                                ['data' => 'eta_time', 'title' => 'ETA date'],
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
                        {!! Form::lbSelect2("priceset_id", null, $bus->pricesets()->toOption("name"), "Priceset") !!}

                        {!! Form::lbDatepicker("start_date", null, "Start date") !!}
                        <div class="form-group">
                            <label>Start time</label>
                            <div class="input-group">
                                <input class="form-control clockpicker" name="start_time" type="text" placeholder="Select time" data-autoclose="true">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>

                        {!! Form::lbDatepicker("eta_date", null, "ETA date") !!}
                        <div class="form-group">
                            <label>ETA time</label>
                            <div class="input-group">
                                <input class="form-control clockpicker" name="eta_time" type="text" placeholder="Select time" data-autoclose="true">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>

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

@push('script')
<script src="/sa/js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('.clockpicker').timepicker({
            showMeridian: false,
            template: false
        });
    });
</script>
@endpush