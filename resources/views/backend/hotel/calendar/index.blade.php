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
    <li>Calendar</li>
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
<?php 
    $begin = Carbon\Carbon::now();
    $end = Carbon\Carbon::now()->addDay(30);
    $array = [];
    for($date = $begin; $date->lte($end->copy()->addDays(-1)); $date->addDay())
    {
        $array[] = $date->copy();
    }
?>
<section id="widget-grid" class="">
    <div class="row">
        @if (isset($hotel))
        @endif
        <article class="col-md-12">
            @box_open(trans("hotel.add.title"))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
                        
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Area</th>
                                        @foreach($array as $date)
                                            <th>{{ $date->format("d/m") }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotel->roomtypes as $room_type)
                                    <tr>
                                        <th colspan="31">{{ $room_type->name_vi }}</th>
                                    </tr>
                                        @foreach($room_type->rooms as $room)
                                        <tr>
                                            <th>{{ $room->name_vi }}</th>
                                            @foreach($array as $date)
                                                @if ($room->order_items()->where("start_date", $date->format("Y-m-d"))->count() == 0)
                                                    <td></td>
                                                @else
                                                    <td>Order</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection