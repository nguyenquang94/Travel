@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_info')
btn-primary
@endsection

@section('html_title')
{{ isset($hotel) ? $hotel->name_vi : "Hotel" }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/hotel">Hotel</a></li>
    @if (isset($hotel))
    <li><a href="/hotel/{{ $hotel->id }}/edit">{{ $hotel->name_vi }}</a></li>
    <li>Edit</li>
    @else
    <li>Add new</li>
    @endif
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
                        {!! Form::lbText("name_vi", @$hotel->name_vi, "Name") !!}
                        {!! Form::lbText("address_vi", @$hotel->address_vi, "Address") !!}
                        {!! Form::lbCKEditor("description_vi", @$hotel->description_vi, "Description") !!}
                        {!! Form::lbCKEditor("how_to_go_vi", @$hotel->how_to_go_vi, "How to go") !!}
                        {!! Form::lbCheckbox("enable_vi", @$hotel->enable_vi, "Enable") !!}
                        {!! Form::lbText("commission", @$hotel->commission, "Commission") !!}
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
