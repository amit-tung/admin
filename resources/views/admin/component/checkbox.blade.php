<div class="form-group">
    <label class="control-label">{{ $title }} {!! !empty($required) && $required==true?'<span class="text-danger">*</span>':'' !!}
        {!! Form::checkbox($name,$value, ['class' => 'form-control'] + $options ) !!}
    </label>
    {{--<span class="help-block" id="error_{{ $name }}"><strong>{{ $errors->first($name) }}</strong></span>--}}
</div>