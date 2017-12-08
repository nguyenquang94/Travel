@extends('app')

@section('sidebar_dp')
active
@endsection

@section('sidebar_dp_setting')
active
@endsection

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans('deeppermission.setting.title') }}
        </h1>
    </div>
</div>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans('deeppermission.setting.title'))
                <div>
                    <div class="widget-body">
						@if (session('dp_announce'))
						<div class="callout callout-success">
							<p>{{ session('dp_announce') }}</p>
						</div>
						@endif
						<p>{{ trans('deeppermission.setting.initial_text') }}</p>
						<a class="btn btn-primary" href="{{ url("permission/setting/initial") }}">{{ trans('deeppermission.setting.initial') }}</a>
						</br>
						<p>Export</p>
						<a class="btn btn-primary" href="{{ url("permission/setting/export") }}"><i class="fa fa-download" aria-hidden="true"></i> {{ trans('deeppermission.setting.export') }}</a>
						</br>
						{!! Form::open(array("url" => "permission/setting/import", "method" => "post", "files" => true)) !!}
						{!! Form::file("import") !!}
						<button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> {{ trans('deeppermission.setting.import') }}</button>
						{!! Form::close() !!}
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection