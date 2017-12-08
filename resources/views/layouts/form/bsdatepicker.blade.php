<div class="form-group">
	@if (isset($title))
	<label class="control-label">{{ $title }}</label>
	@endif

    <?php
    	$attrs = array('class' => 'form-control datepicker', 'data-dateformat' => 'yy-mm-dd');
		if (isset($place_holder))
		{
			$attrs['placeholder'] = $place_holder;
		}
		if (isset($validation))
		{
			$attrs = array_merge($attrs, $validation);
		}
    ?>
    {{ Form::text($name, $value, $attrs) }}

    @if (isset($hin))
	    <div class="note">
	        {{ $hin }}
	    </div>
    @endif
    @if ($errors->has($name))
    	@foreach ($errors->get($name) as $error)
			<div class="note note-error">{{ $error }}</div>
		@endforeach
    @endif
</div>
