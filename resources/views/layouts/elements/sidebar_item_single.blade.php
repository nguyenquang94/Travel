<li class="@yield($id)">
	<a href="{{ url($url) }}" title="{{ $title }}">
		<i class="fa fa-lg fa-fw {{ $icon }}"></i> 
		@if (isset($is_child) && $is_child)
		{{ $title }}
		@else
		<span class="menu-item-parent">{{ $title }}</span>
		@endif
	</a>
</li>