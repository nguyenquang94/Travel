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
        <article class="col-lg-8">
            @box_open(trans("backend.user.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        @include("layouts.elements.table", [
                            'url' => '/lbcore/ajax/library',
                            'columns' => [
                                ['data' => 'code', 'title' => 'Code'],
                                ['data' => 'command_buttons', 'title' => 'Commands'],
                            ]
                        ])
                    </div>
                </div>
            @box_close
        </article>
        <article class="col-lg-4">
            @box_open(trans("backend.user.list.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::open(['url' => '/lbcore/library', 'method' => 'POST']) !!}
                        {!! Form::lbSelect2("library_url", null, [
                            ["name" => "LBCore", "value" => "/lbcore/setting/init"],
                        ], "URL") !!}
                        <div class="widget-footer">
                            {!! Form::lbSubmit() !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
