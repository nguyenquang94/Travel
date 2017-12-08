@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_room')
btn-primary
@endsection

@section('html_title')
{{ isset($bus) ? $bus->name : "Bus" }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/bus">Bus</a></li>
    <li><a href="/bus/{{ $bus->id }}/edit">{{ $bus->name }}</a></li>
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
        @if (isset($bus))
        @include("backend.bus.sidebox")
        @endif
        <article class="col-md-6">
            @box_open(trans("hotel.add.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => "/ajax/bus/$bus->id/manager",
                            'columns' => [
                                ['data' => 'user.name', 'title' => 'Name'],
                                ['data' => 'user.email', 'title' => 'Email'],
                                ['data' => 'type_id', 'title' => 'Type'],
                                ['data' => 'mark_as_primary_button', 'title' => 'Action'],
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
                        {!! Form::open(["url" => "/bus/$bus->id/manager", "method" => "POST"]) !!}
                        {!! Form::lbSelect2("user_id", @$room->area_id, App\Models\User::withRole("bus_manager")->toOption("email"), "Manager") !!}
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