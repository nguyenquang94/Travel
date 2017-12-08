@extends('app')

@section('sidemenu_master')
active
@endsection

@section('sidemenu_master_bank')
active
@endsection

@section('html_title')
Order
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>Master</li>
    <li>Bank</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("order.list.title") }} 
            <span>> 
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
    @include("backend.header_chart")
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name en</th>
                                        <th>Name vi</th>
                                        <th>Parent</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name_en }}</td>
                                        <td>{{ $category->name_vi }}</td>
                                        <td>{{ @$category->parent->name }}</td>
                                        <td>{!! $category->edit_button !!}</td>
                                    </tr>
                                    @endforeach
                                    {!! Form::open(["url" => "/master/transaction_category", "method" => "post"]) !!}
                                    <tr>
                                        <td></td>
                                        <td>{!! Form::lbText("name_en", null, null, "Name en") !!}</td>
                                        <td>{!! Form::lbText("name_vi", null, null, "Name vi") !!}</td>
                                        <td></td>
                                        <td>{!! Form::lbSubmit() !!}</td>
                                    </tr>
                                    {!! Form::close() !!}
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
