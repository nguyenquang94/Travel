@extends('app')

@section('sidemenu_system_balance')
active
@endsection

@section('html_title')
Thêm địa điểm - BWhere Admin
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
                Thêm địa điểm
        </h1>
    </div>
    @include("backend.header_chart")
</div>

<section id="widget-grid" class="">
    <div class="row">
        @if (isset($place))
        {!! Form::open(["url" => "/place/$place->id", "method" => "put"]) !!}
        @else
        {!! Form::open(["url" => "/place", "method" => "post"]) !!}
        @endif
        <article class="col-md-9">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::lbText("short_description_en", @$place->short_description_en, "Mô tả ngắn tiếng anh") !!}
                        {!! Form::lbText("short_description_vi", @$place->short_description_vi, "Mô tả ngắn tiếng việt") !!}
                        {!! Form::lbTextarea("description_en", @$place->description_en, "Mô tả tiếng anh") !!}
                        {!! Form::lbTextarea("description_vi", @$place->description_vi, "Mô tả tiếng việt") !!}
                    </div>
                </div>
            @box_close
        </article>
        <article class="col-md-3">
            @box_open("Thông tin chung")
                <div>
                    <div class="widget-body">
                        {!! Form::lbSelect2(
                            "parent_id", 
                            isset($place) ? $place->parent_id : (request()->has("parent_id") ? request()->parent_id : -1), 
                            App\Models\Place::toOption("name_vi", "id", [["name" => "-- Không chọn --", "value" => -1]]), 
                            "Địa điểm cha"
                        ) !!}
                        {!! Form::lbSelect2("category_id", @$place->category_id, App\Models\MstPlaceCategory::toOption("name_vi"), "Category" ) !!}
                        {!! Form::lbText("name_en", @$place->name_en, "Tên tiếng anh") !!}
                        {!! Form::lbText("name_vi", @$place->name_vi, "Tên tiếng việt") !!}
                        {!! Form::lbText("name_in_url_en", @$place->name_in_url_en, "Tên trên đường link tiếng anh (vd: ha-noi)") !!}
                        {!! Form::lbText("name_in_url_vi", @$place->name_in_url_vi, "Tên trên đường link tiếng việt") !!}
                        {!! Form::lbCheckbox("enable_en", @$place->enable_en, "Enable cho bản tiếng anh") !!}
                        {!! Form::lbCheckbox("enable_vi", @$place->enable_vi, "Enable cho bản tiếng việt") !!}
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
