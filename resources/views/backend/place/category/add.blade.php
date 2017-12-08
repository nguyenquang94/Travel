@extends('app')

@section('sidemenu_system_balance')
active
@endsection

@section('html_title')
Quản lý category địa điểm
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                Quản lý category địa điểm
            <span>> 
                Tạo mói category
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open("Tạo mói category")
                <div>
                    @if (isset($category))
                    {!! Form::open(["url" => "/place/category/$category->id", "method" => "put", "files" => true]) !!}
                    @else
                    {!! Form::open(["url" => "/place/category", "method" => "post", "files" => true]) !!}
                    @endif
                    <div class="widget-body">
                        {!! Form::lbText("name_en", @$category->name_en, "Name en") !!}
                        {!! Form::lbText("name_vi", @$category->name_vi, "Name vi") !!}
                        {!! Form::lbSelect2(
                            "parent_id", 
                            isset($category) ? $category->parent_id : (request()->has("parent_id") ? request()->parent_id : -1), 
                            App\Models\MstPlaceCategory::toOption("name_vi", "id", [["name" => "-- Không chọn --", "value" => -1]]), 
                            "Category cha"
                        ) !!}
                        {!! Form::file("icon") !!}
                        <div class="widget-footer" style="text-align: left;">
                            {!! Form::lbSubmit() !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
