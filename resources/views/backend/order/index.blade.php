@extends('app')

@section('sidemenu_order')
active
@endsection

@section('html_title')
Order
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>Order</li>
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
    <div style="margin-bottom: 8px;">
        <a class="btn btn-primary" href="/order?type_id=1">Admin ({{App\Models\Order::open()->whereTypeId(1)->count()}})</a>
        <a class="btn btn-primary" href="/order?type_id=2">Thanh toán trực tiếp ({{App\Models\Order::open()->whereTypeId(2)->count()}})</a>
        <a class="btn btn-primary" href="/order?type_id=3">Đối tác ({{App\Models\Order::open()->whereTypeId(3)->count()}})</a>
        <a class="btn btn-primary" href="/order?type_id=4">App ({{App\Models\Order::open()->whereTypeId(4)->count()}})</a>
        <a class="btn btn-primary" href="/order?type_id=5">Đại lý ({{App\Models\Order::open()->whereTypeId(5)->count()}})</a>
    </div>
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => '/ajax/order?'.(request()->has('type_id') ? "type_id=".request()->type_id : ""),
                            'columns' => [
                                ['data' => 'created_at', 'title' => 'Created at'],
                                ['data' => 'name', 'title' => 'Name'],
                                ['data' => 'email', 'title' => 'Email'],
                                ['data' => 'phonenumber', 'title' => 'Phone number'],
                                ['data' => 'creator.name', 'title' => 'Creator'],
                                ['data' => 'confirmed_at', 'title' => 'Confirmed date', 'default' => 'Not confirmed yet'],
                                ['data' => 'total_price', 'title' => 'Total', 'type' => 'money'],
                                ['data' => 'in_action', 'title' => 'Is in action'],
                                ['data' => 'status.name', 'title' => 'Status', 'hasFilter' => false],
                                ['data' => 'edit_button', 'title' => 'Edit', 'hasFilter' => false],
                            ],
                            'reloadTime' => 10000,
                        ])
                        <div class="widget-footer" style="text-align: left;">
                            <a href="/order/create" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
