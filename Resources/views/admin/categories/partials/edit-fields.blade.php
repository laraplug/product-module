<div class="box-body">
    {!! Form::normalInput('slug', trans('product::categories.form.slug'), $errors, $category) !!}

    <div class="form-group">
        <label for="parent_id">{{ trans('product::categories.form.parent category') }}</label>
        <select class="form-control" name="parent_id" id="parent_id">
            <option value="0"></option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" {{ $id == $category->parent_id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="status">{{ trans('product::categories.form.status') }}</label>
        <select class="form-control" name="status" id="status">
            <option value="active" {{ $category->status == 'active' ? 'selected' : ''}}>{{ trans('product::categories.form.status active') }}</option>
            <option value="hide" {{ $category->status == 'hide' ? 'selected' : ''}}>{{ trans('product::categories.form.status hide') }}</option>
            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : ''}}>{{ trans('product::categories.form.status inactive') }}</option>
        </select>
    </div>
</div>
