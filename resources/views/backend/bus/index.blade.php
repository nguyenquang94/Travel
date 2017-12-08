@extends('app')

@section('sidemenu_bus')
active
@endsection

@section('sidebox_info')
btn-primary
@endsection

@section('html_title')
Bus Provider management
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>Bus</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("bus.list.title") }} 
            <span>> 
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans("bus.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => '/ajax/bus',
                            'columns' => [
                                ['data' => 'name_vi', 'title' => 'Name'],
                                ['data' => 'name_en', 'title' => 'Name'],
                                ['data' => 'created_at', 'title' => 'Created at', 'hasFilter' => false],
                                ['data' => 'edit_button', 'title' => 'Edit', 'hasFilter' => false, "type" => "html", "orderable" => false],
                            ]
                        ])
                        <div class="widget-footer" style="text-align: left;">
                            <a href="/bus/create" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
