@extends('app')

@section('sidebar_dp')
active
@endsection

@section('sidebar_dp_user_role')
active
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans('deeppermission.user.role') }}
        </h1>
    </div>
</div>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
        	@box_open(trans('deeppermission.user.role'))
                <div>
					<?php
						$roles = App\Models\Role::all();
						$users = App\Models\User::with("roles")->paginate(30);
					?>
					{!! Form::open(array("url" => "user_role", "method" => "post")) !!}
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
					                <tr>
					                	<th>{{ trans('deeppermission.user.username') }}</th>
					                	<th>{{ trans('deeppermission.user.email') }}</th>
					                	@foreach ($roles as $role)
					                	<th><center>{{ $role->name }}</center></th>
					                	@endforeach
					                	<th>{{ trans('deeppermission.general.action') }}</th>
					                </tr>
				                </thead>
				                <tbody>
				                	@foreach ($users as $user)
					                <tr>
					                	<input type="hidden" name="user_check_{{ $user->id}}" value="1" />
					                	<td>{{ $user->name }}</td>
					                	<td>{{ $user->email }}</td>
					                	
					                	@foreach ($roles as $role)
					                	<td>
					                		<center>
					                			<input name="user_{{ $user->id }}[]" type="checkbox" value="{{ $role->id }}"
					                			<?php
					                			foreach ($user->roles as $user_role)
					                			{
					                				if ($user_role->id === $role->id)
													{
														echo "checked"; break;
													}
					                			}
					                			?>
					                			>
					                		</center>
					                	</td>
					                	@endforeach
					                	<td>
					                		<a class="btn btn-sm btn-warning" href="{{ url("/user/$user->id/permission") }}"><i class="fa fa-key"></i></a>
					                	</td>
					                </tr>
					                @endforeach
				                </tbody>
			                </table>
			                {{ $users->links() }}
			            </div>
			            <div class="widget-footer" style="text-align: left;">
			                <button type="submit" class="btn btn-primary">
			                    {{ trans('general.submit')}}
			                </button>
			            </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection