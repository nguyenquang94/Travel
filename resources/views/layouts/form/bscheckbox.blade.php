<div class="checkbox">
	<label>
		<?php
	    	$attrs = [];
			if (isset($attribute))
			{
				$attrs = array_merge($attrs, $attribute);
			}
	    ?>
		{{ Form::checkbox($name, 1, ($value == 1 ? true : false), $attrs) }}
		{{ $title }}
	</label>
</div>
