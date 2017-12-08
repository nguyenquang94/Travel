@extends('app')

@section('sidemenu_order')
active
@endsection

@section('html_title')
Order
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/order">Order</a></li>
    @if (isset($order))
    <li><a href="/order/{{ $order->id }}/edit">{{ $order->id }}</a></li>
    <li>Edit</li>
    @else
    <li>Add new</li>
    @endif
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
        @if (isset($order))
        <article class="col-sm-12">
            @include("backend.order.invoice", ["order" => $order])
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => "/ajax/order/$order->id/transaction",
                            'columns' => [
                                ['data' => 'amount', 'title' => 'Amount'],
                            ]
                        ])
                        <div class="widget-footer">
                            <a class="btn btn-primary" href="{{ url("/order/$order->id/update_transaction") }}">Update transaction</a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
        @else
        <article class="col-sm-12">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::open(["url" => "/order", "method" => "post"]) !!}
                        {!! Form::lbText("name", @$user->name, "Customer's name") !!}
                        {!! Form::lbText("phonenumber", @$user->phonenumber, "Phone number") !!}
                        {!! Form::lbText("email", @$user->email, "Email") !!}
                        {!! Form::lbTextarea("note", @$order->note, "Note") !!}
                        @if (isset($user))
                            {!! Form::hidden("user_id", $user->id) !!}
                        @endif
                        <div class="widget-footer" style="text-align: left;">
                            {!! Form::lbSubmit() !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @box_close
        </article>

        @endif
    </div>
</section>
@endsection