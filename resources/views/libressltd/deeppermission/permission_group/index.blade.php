@extends('app')

@section('sidebar_dp')
active
@endsection

@section('sidebar_dp_group_permission')
active
@endsection

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans('deeppermission.group.title') }}
            <span>
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
        	@box_open(trans('deeppermission.group.title'))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
					                <tr>
					                	<th>#</th>
					                	<th>{{ trans('deeppermission.group.name') }}</th>
					                	<th>{{ trans('deeppermission.group.code') }}</th>
					                	<th>{{ trans('deeppermission.group.permission') }}</th>
					                	<th>{{ trans('deeppermission.general.action') }}</th>
					                </tr>
				                </thead>
				                <tbody>
				                <?php
				                	$groups = App\Models\Permission_group::with("permissions")->paginate(30);
				                ?>
				                	@foreach ($groups as $group)
					                <tr>
					                	<td>{{ $group->id }}.</td>
					                	<td>{{ $group->name }}</td>
					                	<td>{{ $group->code }}</td>
					                	<td>
					                		<?php
					                		$permission_array = array();
					                		foreach ($group->permissions as $permission)
											{
												$permission_array[] = $permission->code;
											}
											echo implode(", ", $permission_array);
					                		?>
					                	</td>
					                	<td>
					                		@if (Auth::user()->hasPermission("permission_group.edit"))
					                		<a class="btn btn-sm btn-primary" href="{{ url("/permission/group/$group->id/edit") }}"><i class="fa fa-edit"></i></a>
					                		@endif
					                		@if (Auth::user()->hasPermission("permission_group.delete"))
					                		{!! Form::lbButton("/permission/group/$group->id", "delete", "<i class=\"fa fa-trash\"></i>", array(
					                			"class" => "btn btn-sm btn-danger",
					                			"onclick" => "return confirm(\"".trans('deeppermission.general.are_you_sure')."\")"
					                		)) !!}
					                		@endif
					                	</td>
					                </tr>
					                @endforeach

									@if (Auth::user()->hasPermission("permission_group.add"))
					                <tr>
					                	<td></td>
										{!! Form::open(array("url" => "permission/group", "method" => "post")) !!}
										<td>{!! Form::lbText("name", "", "", trans('deeppermission.group.name'), null, config("lbform.CNF_REQUIRE_ANUM")) !!}</td>
										<td>{!! Form::lbText("code", "", "", trans('deeppermission.group.code'), null, config("lbform.CNF_REQUIRE_ANUM_AND_POINT")) !!}</td>
										<td>{!! Form::lbSubmit() !!}</td>
										{!! Form::close() !!}
										<td></td>
									</tr>
									@endif
				                </tbody>
				                {{ $groups->links() }}
			                </table>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection