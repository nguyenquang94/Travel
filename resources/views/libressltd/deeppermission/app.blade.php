@extends('app')

@section ('content')
<section id="widget-grid" class="">
	@yield('main-content')
</section>
@endsection

@section ('dp_script')

<script>
	$(function() {
		$('input[type="checkbox"], input[type="radio"]').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
	});
</script>

@endsection