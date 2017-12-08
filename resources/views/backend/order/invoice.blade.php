@box_open("Order #$order->id")
<div>
	<div class="widget-body no-padding">
		<div class="widget-body-toolbar">
			<div class="row">
				<div class="col-sm-12 text-align-right">
					<div class="btn-group">
						<button class="btn btn-sm btn-primary" data-target="#order_info_update_form" data-toggle="modal">
							<i class="fa fa-edit"></i> Edit 
						</button>
					</div>
					<div class="btn-group">
						<button class="btn btn-sm btn-primary" data-target="#order_update_status_form" data-toggle="modal">
							<i class="fa fa-info"></i> Update status 
						</button>
					</div>

					<div class="btn-group">
						<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
							Send info
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="/order/{{ $order->id }}/send_order/mail"> <i class="fa fa-envelope-o"></i> Send Mail </a>
							</li>
							<li>
								<a href="/order/{{ $order->id }}/send_order/contact_mail"> <i class="fa fa-envelope-o"></i> Send Contact Mail </a>
							</li>
							@if ($order->user && $order->user->lbfbc_user && $order->user->lbfbc_user->conversation)
							<li>
								<a href="/order/{{ $order->id }}/send_order/lbfbc"> <i class="fa fa-facebook-official"></i> Send order via facebook </a>
							</li>
							@endif
						</ul>
					</div>
					<div class="btn-group">
						<button class="btn btn-sm btn-danger" data-target="#order_delete_form" data-toggle="modal">
							<i class="fa fa-trash"></i> Delete 
						</button>
					</div>
					<div class="btn-group">
						<a class="btn btn-sm btn-warning" href="/payment/order/{{ $order->id }}/vnpay/create">
							<i class="fa fa-trash"></i> Test payment 
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="row padding-10">
			<div class="col-sm-8">
				<h4 class="semi-bold">{{ $order->name }}</h4>
				<address>
					<strong>Phone: <a href="tel:{{ $order->phonenumber }}">{{ $order->phonenumber }}</a></strong>
					<br>
					Email: <a href="mailto:{{ $order->email }}?subject=B-Where">{{ $order->email }}</a>
					<br>
					Note: {{ $order->note }}
					<br>
					Payment method: {{ @$order->payment_method->bank->shortname }}
					<br>
					Contact information:
					<br>
					@foreach ($order->contact_information() as $contact)
						@if ($contact["type"] == "hotel")
							<br>
							{{ $contact["hotel"]->name_vi }} - {{ $contact["manager"]->name }} - SĐT: {{ $contact["manager"]->phonenumber }}
						@endif
						@if ($contact["type"] == "bus")
							<br>
							{{ $contact["bus"]->name_vi }} - {{ $contact["manager"]->name }} - SĐT: {{ $contact["manager"]->phonenumber }}
						@endif
						@if ($contact["type"] == "service")
							<br>
							{{ $contact["service"]->name_vi }} - {{ $contact["manager"]->name }} - SĐT: {{ $contact["manager"]->phonenumber }}
						@endif
					@endforeach
				</address>
			</div>
			<div class="col-sm-4">
				<div>
					<div>
						<strong>INVOICE NO :</strong>
						<span class="pull-right"> #{{ $order->id }}</span>
					</div>

				</div>
				<div>
					<div class="font-md">
						<strong>INVOICE DATE :</strong>
						<span class="pull-right"> <i class="fa fa-calendar"></i> {{ $order->updated_at->format("d-m-Y") }} </span>
					</div>

				</div>
				<br>
				<div class="well well-sm  bg-color-darken txt-color-white no-border hidden-md">
					<div class="fa-lg">
						Total Profit :
						<span class="pull-right"> {{ number_format($order->profit) }} </span>
					</div>

				</div>
				<br>
				<br>
			</div>
		</div>

		<table class="table table-hover">
			<thead>
				<tr>
					<th class="text-center">QTY</th>
					<th>ITEM</th>
					<th>DATE</th>
					<th>PRICE</th>
					<th>SUBTOTAL</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($order->information() as $item)
				<tr>
					<td class="text-center"><strong>{{ $item["count"] }}</strong></td>
					@if ($item["type"] == "bus")
					<td><a href="javascript:void(0);">Vé xe {{ $item["item"]->info->name }}</a></td>
					<td>{{ $item["date"] }}</td>
					@elseif ($item["type"] == "room")
					<td><a href="javascript:void(0);">Phòng {{ $item["item"]->info->name }} - {{ $item["item"]->info->hotel->name }}</a></td>
					<td>{{ $item["start"] }} - {{ $item["end"] }}</td>
					@elseif ($item["type"] == "custom")
					<td><a href="javascript:void(0);">{{ $item["name"] }}</a></td>
					<td>{{ $item["start"] }}</td>
					@endif
					<td>{{ number_format($item["price"]) }}</td>

					<td class="dt-right">{{ number_format($item["total"]) }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="4">Total</td>
					<td><strong>{{ number_format($order->total_price) }}</strong></td>
				</tr>
			</tbody>
		</table>
		<div class="widget-footer" style="text-align: left;">
			<a href="/order/{{ $order->id }}/item/create" class="btn btn-primary">Add hotel booking</a>
			<a href="/order/{{ $order->id }}/item_bus/create" class="btn btn-primary">Add Bus booking</a>
			<button class="btn btn-sm btn-danger" data-target="#order_add_custom_item_form" data-toggle="modal">
				<i class="fa fa-trash"></i> Add custom item 
			</button>
		</div>
	</div>
</div>
@box_close

<div class="modal fade" id="order_info_update_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Order information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{!! Form::open(["url" => "/order/$order->id", "method" => "PUT"]) !!}
				{!! Form::lbText("name", @$order->name, "Customer's name") !!}
				{!! Form::lbText("phonenumber", @$order->phonenumber, "Phone number") !!}
				{!! Form::lbText("email", @$order->email, "Email") !!}
				{!! Form::lbTextarea("note", @$order->note, "Note") !!}
				{!! Form::lbSelect("system_balance_id", @$order->system_balance_id, App\Models\Balance::system()->toOption("bank.shortname"), "Payment method") !!}
				{!! Form::lbSelect2("type_id", @$order->type_id, App\Models\MstOrderType::toOption('name_vi'), "Order type") !!}
				{!! Form::lbSubmit() !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="order_delete_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Order Delete</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h3>Are you sure you want to delete this order?</h3>
				<h3>(This action cannot be redo)</h3>
				{!! Form::open(["url" => "/order/$order->id", "method" => "delete"])!!}
				<button class="btn btn-danger btn-block" style="margin-top: 5px;">Delete</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="order_update_status_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Order history</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				@include("layouts.elements.table", [
				"url" => "/ajax/order/$order->id/history",
				"columns" => [
				["data" => "created_at", "title" => "Date"],
				["data" => "status.name", "title" => "Status"],
				["data" => "message", "title" => "Message"],
				]
				])
				{!! Form::open(["url" => "/order/$order->id/history", "method" => "POST"]) !!}
				<div class="padding-10">
					{!! Form::lbSelect("status_id", $order->status_id, App\Models\Order_status::toOption(), "Status") !!}
					{!! Form::lbText("message", "", "Message") !!}
				</div>
				<div class="widget-footer padding-10" style="text-align: left;">
					{!! Form::lbSubmit() !!}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="order_add_custom_item_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add custom item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{!! Form::open(["url" => "/order/$order->id/item", "method" => "POST"]) !!}
				{!! Form::hidden("type", "custom") !!}
				{!! Form::lbDatepicker("start_date", Carbon\Carbon::today()->format("Y-m-d"), "Start date") !!}

				{!! Form::lbText("name_en", "", "Name en") !!}
				{!! Form::lbText("name_vi", "", "Name vi") !!}
				{!! Form::lbText("number", "", "Number of item") !!}
				{!! Form::lbText("price", "", "Price") !!}
				{!! Form::lbText("price_bwhere", "", "Price BWhere") !!}
				{!! Form::lbText("price_direct", "", "Price Direct") !!}
				{!! Form::lbSelect("provider_id", null, App\Models\User::withRole("service_provider")->toOption(), "Provider") !!}
				{!! Form::lbSubmit() !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


