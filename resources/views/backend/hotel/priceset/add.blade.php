@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_priceset')
btn-primary
@endsection

@section('html_title')
{{ isset($hotel) ? $hotel->name_vi : "Hotel" }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/hotel">Hotel</a></li>
    <li><a href="/hotel/{{ $hotel->id }}/edit">{{ $hotel->name_vi }}</a></li>
    <li><a href="/hotel/{{ $hotel->id }}/priceset">Price set</a></li>
    <li>{{ $priceset->name_vi }}</li>
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
        <article class="col-md-9">
            {!! Form::open(["url" => "/hotel/$hotel->id/priceset/$priceset->id", "method" => "put"]) !!}
            @box_open(trans("hotel.add.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::lbText("name_vi", $priceset->name_vi, "Name vi") !!}
                        {!! Form::lbText("name_en", $priceset->name_en, "Name en") !!}
                    </div>
                </div>
            @box_close
            @box_open(trans("hotel.add.title"))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Room type</th>
                                        <th>Price BWhere to customer</th>
                                        <th>Price Hotel to BWhere</th>
                                        <th>Price Hotel to customer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotel->roomtypes as $type)
                                    <tr>
                                        <td>{{ $type->name_vi }}</td>
                                        <?php
                                            $item = App\Models\Hotel_priceset_item::where("priceset_id", $priceset->id)->where("room_type_id", $type->id)->first();
                                        ?>
                                        @if ($item)
                                        <td>{!! Form::lbText($type->id, $item->price) !!}</td>
                                        <td>{!! Form::lbText($type->id."_bwhere", $item->price_bwhere) !!}</td>
                                        <td>{!! Form::lbText($type->id."_direct", $item->price_direct) !!}</td>
                                        @else
                                        <td>{!! Form::lbText($type->id) !!}</td>
                                        <td>{!! Form::lbText($type->id."_bwhere") !!}</td>
                                        <td>{!! Form::lbText($type->id."_direct") !!}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="widget-footer" style="text-align: left;">
                            {!! Form::lbSubmit() !!}
                        </div>
                    </div>
                </div>
            @box_close
            {!! Form::close() !!}
        </article>
    </div>
</section>
@endsection