@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('html_title')
Hotel
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>Hotel</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("hotel.list.title") }} 
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
                            'url' => '/ajax/hotel',
                            'columns' => [
                                ['data' => 'name_vi', 'title' => 'Name'],
                                ['data' => 'address_vi', 'title' => 'Address'],
                                ['data' => 'enable_vi', 'title' => 'Enable vi', 'hasFilter' => false],
                                ['data' => 'edit_button', 'title' => 'Edit', 'hasFilter' => false, "type" => "html", "orderable" => false, 'defaultContent' => ''],
                            ]
                        ])
                        <div class="widget-footer" style="text-align: left;">
                            <a href="/hotel/create" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
