@extends('app')

@section ('contentheader_title')
{{ trans('deeppermission.header.title') }}
@endsection

@section ('sidebar_dp')
active
@endsection

@section ('sidebar_dp_permission')
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
	        @if (!isset($permission))
			@box_open(trans('deeppermission.permission.add'))
			Add new Permission
			@else
			@box_open(trans('deeppermission.permission.edit').": ".$permission->name)
			@endif
                <div>
					@if (!isset($permission))
					{!! Form::open(array("url" => "permission", "method" => "post")) !!}
					@else
					{!! Form::open(array("url" => "permission/$permission->id", "method" => "put")) !!}
					@endif
                    <div class="widget-body">
						{!! Form::lbAlert() !!}
						{!! Form::lbText("name", @$permission->name, trans('deeppermission.permission.name'), trans('deeppermission.permission.name_hint'), null, config("deeppermission.CNF_REQUIRE_ANUM")) !!}
						{!! Form::lbText("code", @$permission->code, trans('deeppermission.permission.code'), trans('deeppermission.permission.code_hint'), trans('deeppermission.permission.code_note'), config("deeppermission.CNF_REQUIRE_ANUM_AND_POINT")) !!}
						{!! Form::lbSelect2("permission_group_id", @$permission->permission_group_id, App\Models\Permission_group::toOption(), trans('deeppermission.permission.group_permission')) !!}
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