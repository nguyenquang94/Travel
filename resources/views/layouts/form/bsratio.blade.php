<div class="form-group">
    {{ Form::label($title, null, ['class' => 'control-label']) }}
    @foreach ($items as $item)
  	<div class="radio">
    	<label>
      		<input type="radio" name="{{$name}}" id="optionsRadios1" value="{{ $item['value'] }}" {{ ($value == $item['value']) ? 'checked' : '' }}>
      		{{ $item['name'] }}
    	</labl>
  	</div>
  	@endforeach
</div>
