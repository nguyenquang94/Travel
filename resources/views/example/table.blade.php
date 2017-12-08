@extends('app')

@section('sidemenu_user')
active
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("backend.user.list.title") }} 
            <span>> 
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans("backend.user.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => '/ajax/user',
                            'columns' => [
                                ['data' => 'name', 'title' => 'Name'],
                                ['data' => 'email', 'title' => 'Email'],
                                ['data' => 'account_balance', 'title' => 'Balance', "defaultContent" => 0],
                                ['data' => 'created_at', 'title' => 'Created at'],
                                ['data' => 'transaction_button', 'title' => 'Transaction', 'hasFilter' => false],
                            ]
                        ])
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
