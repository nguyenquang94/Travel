@extends('app')

@section('sidebar_dp')
active
@endsection

@section('sidebar_dp_role')
active
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans('deeppermission.header.title') }}
            <span>
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
        	@box_open(trans('deeppermission.role.title'))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
					                <tr>
					                	<th>#</th>
					                	<th>{{ trans('deeppermission.role.name') }}</th>
					                	<th>{{ trans('deeppermission.role.code') }}</th>
					                	<th>{{ trans('deeppermission.general.action') }}</th>
					                </tr>
				                </thead>
				                <tbody>
				                <?php
				                	$roles = App\Models\Role::paginate(30);
				                ?>
				                	@foreach ($roles as $role)
					                <tr>
					                	<td>{{ $role->id }}.</td>
					                	<td>{{ $role->name }}</td>
					                	<td>{{ $role->code }}</td>
					                	<td>
					                		@if (Auth::user()->hasPermission("role.edit"))
					                		<a class="btn btn-sm btn-primary" href="{{ url("/role/$role->id/edit") }}"><i class="fa fa-edit"></i></a>
					                		<a class="btn btn-sm btn-warning" href="{{ url("/role/$role->id/permission") }}"><i class="fa fa-key"></i></a>
					                		@endif
					                		
					                		@if (Auth::user()->hasPermission("role.delete"))
					                		{!! Form::lbButton("/role/$role->id", "delete", "<i class=\"fa fa-trash\"></i>", array(
					                			"class" => "btn btn-sm btn-danger",
					                			"onclick" => "return confirm(\"".trans('deeppermission.general.are_you_sure')."\")"
					                		)) !!}
					                		@endif
					                	</td>
					                </tr>
					                @endforeach
									@if (Auth::user()->hasPermission("role.add"))
					                <tr>
										{!! Form::open(array("url" => "role", "method" => "post")) !!}
					                	<td></td>
										<td>
											{!! Form::lbText("name", "", "", trans('deeppermission.role.name'), null, config("deeppermission.CNF_REQUIRE_ANUM")) !!}
										</td>
										<td>
											{!! Form::lbText("code", "", "", trans('deeppermission.role.code'), null, config("deeppermission.CNF_REQUIRE_ANUM_AND_POINT")) !!}
										</td>
										<td>
											{!! Form::lbSubmit() !!}
										</td>
										{!! Form::close() !!}

								    </tr>
									@endif
								</tbody>
							</table>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection