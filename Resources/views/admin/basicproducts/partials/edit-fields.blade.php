<div class='form-group{{ $errors->has('productable[weight]') ? ' has-error' : '' }}'>
    {!! Form::label('productable[weight]', trans('product::basicproducts.weight')) !!}
    {!! Form::text('productable[weight]', old('productable[weight]', $product->productable->weight), ['class' => 'form-control', 'placeholder' => trans('product::basicproducts.weight')]) !!}
    {!! $errors->first('productable[weight]', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('productable[height]') ? ' has-error' : '' }}'>
    {!! Form::label('productable[height]', trans('product::basicproducts.height')) !!}
    {!! Form::text('productable[height]', old('productable[height]', $product->productable->height), ['class' => 'form-control', 'placeholder' => trans('product::basicproducts.height')]) !!}
    {!! $errors->first('productable[height]', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('productable[width]') ? ' has-error' : '' }}'>
    {!! Form::label('productable[width]', trans('product::basicproducts.width')) !!}
    {!! Form::text('productable[width]', old('productable[width]', $product->productable->width), ['class' => 'form-control', 'placeholder' => trans('product::basicproducts.width')]) !!}
    {!! $errors->first('productable[width]', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('productable[length]') ? ' has-error' : '' }}'>
    {!! Form::label('productable[length]', trans('product::basicproducts.length')) !!}
    {!! Form::text('productable[length]', old('productable[length]', $product->productable->length), ['class' => 'form-control', 'placeholder' => trans('product::basicproducts.length')]) !!}
    {!! $errors->first('productable[length]', '<span class="help-block">:message</span>') !!}
</div>
