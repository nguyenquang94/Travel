
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title> Thanh toán đơn hàng </title>
		<meta name="description" content="">
		<meta name="author" content="">
			
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/sa/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/sa/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/sa/css/smartadmin-production-plugins.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/sa/css/smartadmin-production.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/sa/css/smartadmin-skins.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/sa/css/smartadmin-rtl.min.css') }}"> 
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/sa/css/demo.min.css') }}">
		<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
	</head>
	<body class="menu-on-top">
		<header id="header">
			<div id="logo-group">
				<span id="logo"> BWhere </span>
			</div>
		</header>
		<div id="main" role="main">
			<div id="content">
				@box_open("Order #$order->id")
					<div>
						<div class="widget-body no-padding">
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
							{!! Form::open(["url" => "/payment/order/$order->id/vnpay", "method" => "GET"]) !!}
				            <div class="widget-footer" style="text-align: left;">
				                {!! Form::lbSelect("payment_method", "", App\Models\MstVnpayBank::toOption("name_vi", "code"), "Phương thức thanh toán") !!}
												{!! Form::lbSubmit("Chọn") !!}
				            </div>
				            {!! Form::close() !!}
						</div>
					</div>
				@box_close
			</div>
		</div>
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">BWhere Project <span class="hidden-xs"> - Công ty TNHH Beliat</span> Tầng 5, số 72 Tây Sơn, Hà Nội</span>
				</div>
			</div>
		</div>
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('/sa/js/plugin/pace/pace.min.js') }}"></script>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
			}
		</script>

		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
			}
		</script>
		<script src="{{ asset('/sa/js/app.config.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script> 
		<script src="{{ asset('/sa/js/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ asset('/sa/js/notification/SmartNotification.min.js') }}"></script>
		<script src="{{ asset('/sa/js/smartwidgets/jarvis.widget.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/select2/select2.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>
		<script src="{{ asset('/sa/js/plugin/fastclick/fastclick.min.js') }}"></script>
		<script src="{{ asset('/sa/js/app.min.js') }}"></script>
		<script src="{{ asset('/sa/js/speech/voicecommand.min.js') }}"></script>
		<script src="{{ asset('/sa/js/smart-chat-ui/smart.chat.ui.min.js') }}"></script>
		<script src="{{ asset('/sa/js/smart-chat-ui/smart.chat.manager.min.js') }}"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				 pageSetUp();
			})
		</script>
	</body>
</html>