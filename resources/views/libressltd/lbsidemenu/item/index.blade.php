@extends('app')

@section('sidemenu_lbsm_item')
active
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans('lbsm.item.list.title') }}
            <span>
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
        	@box_open(trans('lbsm.item.list.title'))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
					                <tr>
					                	<th>{{ trans('lbsm.item.title.name') }}</th>
					                	<th>{{ trans('lbsm.item.title_translated.name') }}</th>
					                	<th>{{ trans('lbsm.item.icon.name') }}</th>
					                	<th>{{ trans('lbsm.item.url.name') }}</th>
					                	<th>{{ trans('lbsm.item.id_string.name') }}</th>
					                	<th>{{ trans('lbsm.item.order.name') }}</th>
					                	<th>{{ trans('lbsm.item.parent.name') }}</th>
					                	<th>{{ trans('lbsm.item.role.name') }}</th>
					                	<th>{{ trans('lbsm.item.permission.name') }}</th>
					                	<th>{{ trans('general.action') }}</th>
					                </tr>
				                </thead>
				                <tbody>
				                	@foreach ($items as $item)
					                <tr>
					                	<td>{{ $item->title }}</td>
					                	<td>{{ $item->title_translated }}</td>
					                	<td>{{ $item->icon }}</td>
					                	<td>{{ $item->url }}</td>
					                	<td>{{ $item->id_string }}</td>
					                	<td>{{ $item->order_number }}</td>
					                	<td>{{ @$item->parent->title }}</td>
					                	<td>
					                		@foreach ($item->roles as $role)
					                			{{ $role->name }}, 
					                		@endforeach
					                	</td>
					                	<td>
					                		@foreach ($item->permissions as $permission)
					                			{{ $permission->name }}, 
					                		@endforeach
					                	</td>
					                	<td>
					                		<a href="{{ url("/lbsm/item/$item->id/edit") }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
					                		@if ($item->children->count() == 0)
					                		{!! Form::lbButton("/lbsm/item/$item->id", "delete", "<i class=\"fa fa-trash\"></i>", ["class" => "btn btn-danger"]) !!}
					                		@endif
					                	</td>
					                </tr>
					                @endforeach
					                {!! Form::open(["url" => "/lbsm/item", "method" => "post", "files" => true]) !!}
					                <tr>
					                	<td>{!! Form::lbText("title", null, null, "Title") !!}</td>
					                	<td>{!! Form::lbCheckbox("title_translated") !!}</td>
					                	<td>{!! Form::lbSelectIcon("icon")!!}</td>
					                	<td>{!! Form::lbText("url", null, null, "URL") !!}</td>
					                	<td>{!! Form::lbText("id_string", null, null, "ID") !!}</td>
					                	<td>{!! Form::lbText("order_number", null, null, "Order") !!}</td>
					                	<td>{!! Form::lbSelect2("parent_id", null, App\Models\LBSM_item::toOption("id_string", "id", [["name" => "None", "value" => -1]])) !!}</td>
	                					<td>{!! Form::lbSelect2multi("roles[]", null, App\Models\Role::toOption("code")) !!}</td>
	                					<td>{!! Form::lbSelect2multi("permissions[]", null, App\Models\Permission::toOption("code")) !!}</td>
					                	<td>{!! Form::lbSubmit() !!}</td>
					                </tr>
					                {!! Form::close() !!}
				                </tbody>
			                </table>
                        </div>
                        @if (!App\Models\LBSM_item::item_exist("sidemenu_lbsm_item"))
                        <div class="widget-footer" style="text-align: left;">
                        	<a class="btn btn-primary" href="/lbsm/item/init">Create sidemenu</a>
                        </div>
                        @endif
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection