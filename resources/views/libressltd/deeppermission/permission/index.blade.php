@extends('app')

@section('sidebar_dp')
active
@endsection

@section('sidebar_dp_permission')
active
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans('deeppermission.permission.title') }}
            <span>
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
        	@box_open(trans('deeppermission.permission.title'))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
					                <tr>
					                	<th>#</th>
					                	<th>{{ trans('deeppermission.permission.name') }}</th>
					                	<th>{{ trans('deeppermission.permission.code') }}</th>
					                	<th>{{ trans('deeppermission.permission.group_permission') }}</th>
					                	<th>{{ trans('deeppermission.general.action') }}</th>
					                </tr>
				                </thead>
				                <tbody>
				                <?php
				                	$permissions = App\Models\Permission::paginate(30);
				                ?>
				                	@foreach ($permissions as $permission)
					                <tr>
					                	<td>{{ $permission->id }}.</td>
					                	<td>{{ $permission->name }}</td>
					                	<td>{{ $permission->code }}</td>
					                	<td>{{ @$permission->group->name }}</td>
					                	<td>
					                		@if (Auth::user()->hasPermission("permission.edit"))
					                		<a class="btn btn-sm btn-primary" href="{{ url("/permission/$permission->id/edit") }}"><i class="fa fa-edit"></i></a>
					                		@endif
					                		@if (Auth::user()->hasPermission("permission.delete"))
					                		{!! Form::lbButton("/permission/$permission->id", "delete", "<i class=\"fa fa-trash\"></i>", array(
					                			"class" => "btn btn-sm btn-danger",
					                			"onclick" => "return confirm(\"".trans('deeppermission.general.are_you_sure')."\")"
					                		)) !!}
					                		@endif
					                	</td>
					                </tr>
					                @endforeach
									@if (Auth::user()->hasPermission("permission.add"))
					                <tr>
										{!! Form::open(array("url" => "permission", "method" => "post")) !!}
										<td></td>
										<td>{!! Form::lbText("name", "", "", trans('deeppermission.permission.name'), null, config("deeppermission.CNF_REQUIRE_ANUM")) !!}</td>
										<td>{!! Form::lbText("code", "", "", trans('deeppermission.permission.code'), null, config("deeppermission.CNF_REQUIRE_ANUM_AND_POINT")) !!}</td>
										<td>{!! Form::lbSelect2("permission_group_id", "0", App\Models\Permission_group::toOption(), null) !!}</td>
										<td>{!! Form::lbSubmit() !!}</td>
										{!! Form::close() !!}
								     </tr>
									@endif
				                </tbody>
			                </table>
			                {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection