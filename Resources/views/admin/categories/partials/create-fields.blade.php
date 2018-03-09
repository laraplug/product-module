<div class="box-body">
    {!! Form::normalInput('slug', trans('product::categories.form.slug'), $errors) !!}

    <div class="form-group">
        <label for="parent_id">{{ trans('product::categories.form.parent category') }}</label>
        <select class="form-control" name="parent_id" id="parent_id">
            <option value="0"></option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="status">{{ trans('product::categories.form.status') }}</label>
        <select class="form-control" name="status" id="status">
            <option value="active">{{ trans('product::categories.form.status active') }}</option>
            <option value="hide">{{ trans('product::categories.form.status hide') }}</option>
            <option value="inactive">{{ trans('product::categories.form.status inactive') }}</option>
        </select>
    </div>
</div>
