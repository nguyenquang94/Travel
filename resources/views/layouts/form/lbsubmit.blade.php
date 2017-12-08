<?php
	$attrs = array('class' => 'btn btn-primary', 'onclick' => 'this.disabled = true;this.form.submit();');
	if (isset($attribute))
	{
		$attrs = array_merge($attrs, $attribute);
	}
?>
{{ Form::submit((isset($title) ? $title : 'Submit'), $attrs) }}