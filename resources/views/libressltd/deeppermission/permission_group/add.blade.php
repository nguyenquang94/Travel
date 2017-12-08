@extends('app')

@section ('contentheader_title')
{{ trans('deeppermission.header.title') }}
@endsection

@section ('sidebar_dp_permission_group')
active
@endsection

@section ('sidebar_dp')
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
        	@if (!isset($group))
			@box_open(trans('deeppermission.group.add'))
			@else
			@box_open(trans('deeppermission.group.edit').": ".$group->name)
			@endif
                <div>
					@if (!isset($group))
					{!! Form::open(array("url" => "permission/group", "method" => "post")) !!}
					@else
					{!! Form::open(array("url" => "permission/group/$group->id", "method" => "put")) !!}
					@endif
                    <div class="widget-body">
						{!! Form::lbAlert() !!}
						{!! Form::lbText("name", @$group->name, trans('deeppermission.group.name'), trans('deeppermission.group.name_hint'), null, config("deeppermission.CNF_REQUIRE_ANUM")) !!}
						{!! Form::lbText("code", @$group->code, trans('deeppermission.group.code'), trans('deeppermission.group.code_hint'), trans('deeppermission.group.code_note'), config("deeppermission.CNF_REQUIRE_ANUM_AND_POINT")) !!}
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