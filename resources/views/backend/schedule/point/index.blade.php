@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('html_title')
schedule
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>Điểm dừng của lịch trình {{ $schedule->name_vi }}</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("schedule.list.title") }} 
            <span>> 
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans("hotel.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => "/ajax/schedule/$schedule->id/point",
                            'columns' => [
                                ['data' => 'estimated_day', 'title' => 'Day'],
                                ['data' => 'estimated_time', 'title' => 'Time'],
                                ['data' => 'description_vi', 'title' => 'Description vi'],
                                ['data' => 'estimated_cost', 'title' => 'Cost'],
                                ['data' => 'estimated_distance', 'title' => 'Distance (km)'],
                                ['data' => 'edit_button', 'title' => 'Edit'],
                            ]
                        ])
                        <div class="widget-footer" style="text-align: left;">
                            <a href="/schedule/{{ $schedule->id }}/point/create" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
