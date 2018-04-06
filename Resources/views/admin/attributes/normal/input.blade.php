<div class="form-group {{ $errors->has("attributes.$attribute->slug") ? 'has-error' : '' }}">
    {!! Form::label("attributes[$attribute->slug]", $attribute->name) !!}
    {!! Form::text("attributes[$attribute->slug]", old("attributes.$attribute->slug", $entity->findAttributeValueContent($attribute->slug)),
        [
            'class' => 'form-control',
            'data-slug' => $attribute->slug,
            'data-is-collection' => $attribute->isCollection()
        ]) !!}
    {!! $errors->first("attributes.$attribute->slug", '<span class="help-block">:message</span>') !!}
</div>
