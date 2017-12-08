@extends('app')

@section('sidemenu_user')
active
@endsection

@section('html_title')
{{ $user->name }}'s Transaction
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("user.list.title") }} 
            <span>> 
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => "/ajax/user/$user->id/transaction",
                            'columns' => [
                                ['data' => 'created_at', 'title' => 'Created_at'],
                                ['data' => 'amount', 'title' => 'Amount', 'type' => 'money'],
                                ['data' => 'type.name', 'title' => 'Type'],
                                ['data' => 'order.info_button', 'title' => 'Order', 'defaultContent' => ''],
                                ['data' => 'order.name', 'title' => 'Customer', 'defaultContent' => ''],
                                ['data' => 'category.name', 'title' => 'Category'],
                                ['data' => 'delete_button', 'title' => trans('general.delete')],
                            ]
                        ])
                        <div class="widget-footer" style="text-align: left;">
                            <a href="{{ url("/user/$user->id/transaction/create") }}" class="btn btn-primary">Withdrawal</a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
