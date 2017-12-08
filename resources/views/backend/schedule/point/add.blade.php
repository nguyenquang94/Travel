@extends('app')

@section('sidemenu_system_balance')
active
@endsection

@section('html_title')
Thêm điểm vào lịch trình - BWhere Admin
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
            Thêm điểm vào lịch trình {{ $schedule->name_vi }}
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        @if (isset($point))
        {!! Form::open(["url" => "/schedule/$schedule->id/point/$point->id", "method" => "put"]) !!}
        @else
        {!! Form::open(["url" => "/schedule/$schedule->id/point", "method" => "post"]) !!}
        @endif
        <article class="col-md-9">
            @box_open(trans("user.list.title"))
            <div>
                <div class="widget-body">
                    {!! Form::lbTextarea("description_vi", @$point->description_vi, "Description vi") !!}
                    {!! Form::lbTextarea("description_en", @$point->description_en, "Description en") !!}
                </div>
            </div>
            @box_close
        </article>
        <article class="col-md-3">
            @box_open("Thông tin chung")
            <div>
                <div class="widget-body">
                    <div class="form-group">
                        <label>Estimated time</label>
                        <div class="input-group">
                            <input class="form-control clockpicker" name="estimated_time" type="text" placeholder="Select time" data-autoclose="true" value="{{ @$point->estimated_time }}">
                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </div>
                    {!! Form::lbText("estimated_day", @$point->estimated_day, "Estimated day (start by 1)") !!}
                    {!! Form::lbText("estimated_cost", @$point->estimated_cost, "Estimated cost") !!}
                    {!! Form::lbText("estimated_distance", @$point->estimated_distance, "Estimated distance (from last point)") !!}
                    @if (@$point)
                    {!! Form::lbSelect2multi("place_ids[]", $point->places->pluck("id")->toArray(), App\Models\Place::toOption("name_vi"), "Places") !!}
                    @else
                    {!! Form::lbSelect2multi("place_ids[]", null, App\Models\Place::toOption("name_vi"), "Places") !!}
                    @endif

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