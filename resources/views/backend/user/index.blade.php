@extends('app')

@section('sidemenu_user')
active
@endsection

@section('html_title')
User
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
                            'url' => '/ajax/user',
                            'columns' => [
                                ['data' => 'name', 'title' => 'Name'],
                                ['data' => 'email', 'title' => 'Email'],
                                ['data' => 'balance', 'title' => 'Balance', 'type' => 'money'],
                                ['data' => 'transaction_button', 'title' => 'Transaction'],
                                ['data' => 'edit_button', 'title' => 'Edit'],
                                ['data' => 'created_at', 'title' => 'Created at', 'hasFilter' => false],
                            ]
                        ])
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
