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
            @box_open("test")
                <div>
                    <a class="btn btn-primary" href="/lbcore/library/-1">test</a>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
