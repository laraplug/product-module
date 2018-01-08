<div class="box-body">
    <div class="form-group">
        <label for="parent_id">{{ trans('product::categories.form.parent category') }}</label>
        <select class="form-control" name="parent_id" id="parent_id">
            <option value=""></option>
            @foreach ($categories as $item)
                <option value="{{ $item->id }}" {{ $item->id == $category->parent_id ? 'selected' : '' }}>{{ $item->name }}</option>
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
