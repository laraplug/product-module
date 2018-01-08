<div class="box-body">
    <div class="form-group">
        <label for="parent_id">{{ trans('product::categories.form.parent category') }}</label>
        <select class="form-control" name="parent_id" id="parent_id">
            <option value=""></option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
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
