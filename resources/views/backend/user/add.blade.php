@extends('app')

@section('sidemenu_user')
active
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("bus.add.title") }} 
            <span>> 
                {{ trans("general.add") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        @if (isset($bus))
        @include("backend.bus.sidebox")
        @endif
        <article class="col-md-9">
            @box_open($user->name)
                <div>
                    {!! Form::open(["url" => "/user/$user->id", "method" => "put"]) !!}
                    <div class="widget-body">
                        {!! Form::lbText("password", null, "Password") !!}
                        {!! Form::lbText("name", @$user->name, "Phone number") !!}
                        {!! Form::lbText("email", @$user->email, "Phone number") !!}
                        {!! Form::lbText("phonenumber", @$user->phonenumber, "Phone number") !!}
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
