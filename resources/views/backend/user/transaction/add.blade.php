@extends('app')

@section('sidemenu_bus')
active
@endsection

@section('sidebox_info')
btn-primary
@endsection

@section('html_title')

@if (isset($bus))
{{ $bus->name }}
@else
Create new Bus Provider
@endif

@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/bus">Bus</a></li>
    @if (isset($bus))
    <li><a href="/bus/{{ $bus->id }}/edit">{{ $bus->name }}</a></li>
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
            @box_open(trans("bus.add.title"))
                <div>
                    {!! Form::open(["url" => "/user/$user->id/transaction", "method" => "post"]) !!}
                    <div class="widget-body">
                        {!! Form::lbSelect("from_id", null, App\Models\Balance::system()->toOption("brief_information"), "From") !!}
                        {!! Form::lbText("amount", $user->balance, "Amount") !!}
                        {!! Form::lbText("fee", 0, "Fee") !!}
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
