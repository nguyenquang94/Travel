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
                    @if (isset($bus))
                    {!! Form::open(["url" => "/bus/$bus->id", "method" => "put"]) !!}
                    @else
                    {!! Form::open(["url" => "/bus", "method" => "post"]) !!}
                    @endif
                    <div class="widget-body">
                        {!! Form::lbText("name_en", @$bus->name_en, "Name en") !!}
                        {!! Form::lbText("name_vi", @$bus->name_vi, "Name vi") !!}
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
