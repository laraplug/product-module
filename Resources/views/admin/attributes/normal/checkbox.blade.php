<div class="form-group {{ $errors->has('attributes.' . $attribute->slug) ? 'has-error' : '' }}">
    {!! Form::label($attribute->name, $attribute->name) !!}

    <?php foreach ($attribute->options as $key => $option): ?>
    <label class="checkbox">
        <input type="checkbox" name="attributes[{{ $attribute->code }}][]"
                class="flat-blue"
                data-slug="{{ $attribute->code }}"
                value="{{ $key }}" {{ $entity->findAttributeValue($attribute->code, $key) ? 'checked' : '' }}>
        {{ $option->getLabel() }}
    </label>
    <?php endforeach; ?>
    {!! $errors->first('attributes.' . $attribute->slug, '<span class="help-block">:message</span>') !!}
</div>
