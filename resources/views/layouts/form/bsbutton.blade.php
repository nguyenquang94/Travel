<div style="display: inline-block;">
{!! Form::open(array('url' => $url, 'method' => $method)) !!}
	<button 
	@foreach (array_keys($attribute) as $a)
		{{ $a }}="{{ $attribute[$a] }}" 
	@endforeach
	type="submit">{!! $title !!}</button>
{!! Form::close() !!}
</div>