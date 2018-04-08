<select name="options[{{ $option->slug }}]"
    @if($elemAttributes)
    @foreach ($elemAttributes as $key => $value)
    {!! is_string($key) ? "$key='$value'" : $value !!}
    @endforeach
    @endif
    >
    @if(!$option->required)
    <option value="">{{ trans('product::options.please select') }}</option>
    @endif
    <?php foreach ($option->values as $value): ?>
    <option value="{{ $value->code }}">{{ $value->name }}</option>
    <?php endforeach; ?>
</select>
