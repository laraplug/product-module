<div class='form-group{{ $errors->has("{$lang}[name]") ? ' has-error' : '' }}'>
    {!! Form::label("{$lang}[name]", trans('product::categories.form.name')) !!}
    <?php $old = $category->hasTranslation($lang) ? $category->translate($lang)->name : '' ?>
    {!! Form::text("{$lang}[name]", old("{$lang}[name]", $old), ['class' => 'form-control', 'placeholder' => trans('product::categories.form.name'), 'autofocus']) !!}
    {!! $errors->first("{$lang}[name]", '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has("{$lang}[description]") ? ' has-error' : '' }}'>
    {!! Form::label("{$lang}[description]", trans('product::categories.form.description')) !!}
    <?php $old = $category->hasTranslation($lang) ? $category->translate($lang)->description : '' ?>
    {!! Form::textarea("{$lang}[description]", old("{$lang}[description]", $old), ['class' => 'form-control', 'placeholder' => trans('product::categories.form.description'), 'autofocus']) !!}
    {!! $errors->first("{$lang}[description]", '<span class="help-block">:message</span>') !!}
</div>
