<?php
	use App\Models\Order;
	$orders = [];
	for ($i = - 11; $i <= 0; $i ++)
	{
		$orders[] = Order::success()->weekly($i)->whereIn("type_id", [1, 2, 4])->get();
	}
	$monthly_order = Order::success()->monthly(0)->whereIn("type_id", [1, 2, 4])->get();
?>

<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
	<ul id="sparks" class="">
		<li class="sparks-info">
			<h5> Income <span class="txt-color-blue"> {{ number_format($monthly_order->sum("total_price")) }}</span></h5>
			<div class="sparkline txt-color-blue hidden-mobile">
			@foreach ($orders as $order)
				{{ $order->sum("total_price") }}
				@if (!$loop->last)
				,
				@endif
			@endforeach
			</div>
		</li>
		<li class="sparks-info">
			<h5> Profit <span class="txt-color-purple"> {{ number_format($monthly_order->sum("total_price") - $monthly_order->sum("total_price_bwhere")) }}</span></h5>
			<div class="sparkline txt-color-purple hidden-mobile">
			@foreach ($orders as $order)
				{{ $order->sum("total_price") - $order->sum("total_price_bwhere") }}
				@if (!$loop->last)
				,
				@endif
			@endforeach
			</div>
		</li>
		<li class="sparks-info">
			<h5> Order <span class="txt-color-greenDark"> {{ number_format($monthly_order->count()) }}</span></h5>
			<div class="sparkline txt-color-greenDark hidden-mobile">
			@foreach ($orders as $order)
				{{ $order->count() }}
				@if (!$loop->last)
				,
				@endif
			@endforeach
			</div>
		</li>
	</ul>
</div>
