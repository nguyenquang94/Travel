<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
			
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src="{{ asset('sa/img/avatars/sunny.png') }}" alt="me" class="online" /> 
				<span>
					@if (Auth::user())
					{{ Auth::user()->name }}
					@endif
				</span>
				<i class="fa fa-angle-down"></i>
			</a> 
			
		</span>
	</div>
	<nav>
		<ul>
			@stack("sidebar")
		</ul>
	</nav>
	

	<span class="minifyme" data-action="minifyMenu"> 
		<i class="fa fa-arrow-circle-left hit"></i> 
	</span>

</aside>