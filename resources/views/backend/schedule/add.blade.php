@extends('app')

@section('sidemenu_system_balance')
active
@endsection

@section('html_title')
Thêm lịch trình - BWhere Admin
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>System</li>
    <li>Balance</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
            Thêm lịch trình
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        @if (isset($schedule))
        {!! Form::open(["url" => "/schedule/$schedule->id", "method" => "put"]) !!}
        @else
        {!! Form::open(["url" => "/schedule", "method" => "post"]) !!}
        @endif
        <article class="col-md-9">
            @box_open(trans("user.list.title"))
            <div>
                <div class="widget-body">
                    {!! Form::lbText("name_vi", @$schedule->name_vi, "Name vi") !!}
                    {!! Form::lbText("name_en", @$schedule->name_en, "Name en") !!}
                    {!! Form::lbTextarea("description_vi", @$schedule->description_vi, "Description vi") !!}
                    {!! Form::lbTextarea("description_en", @$schedule->description_en, "Description en") !!}
                </div>
            </div>
            @box_close
        </article>
        <article class="col-md-3">
            @box_open("Thông tin chung")
            <div>
                <div class="widget-body">
                    {!! Form::lbText("estimated_time", @$schedule->estimated_time, "Estimated time (day)", "Example: 2") !!}
                    {!! Form::lbText("estimated_cost", @$schedule->estimated_cost, "Estimated cost (VND)", "Example: 700000") !!}
                    {!! Form::lbText("traffic_vi", @$schedule->traffic_vi, "Traffic vi", "Example: Xe khách & xe máy") !!}
                    {!! Form::lbText("traffic_en", @$schedule->traffic_en, "Traffic en", "Example: Bus & motorbike") !!}

                    <div class="widget-footer" style="text-align: left;">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-category-modal">Lưu</button>
                    </div>
                </div>
            </div>
            @box_close
        </article>
        {!! Form::close() !!}
    </div>
</section>

@endsection
