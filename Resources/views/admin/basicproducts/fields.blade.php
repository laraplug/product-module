<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('product::products.title.shipping') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group {{ $errors->has('shipping_method_id') ? 'has-error' : '' }}">
                    <label for="shipping_method_id">{{ trans('product::basicproducts.shipping_method') }}</label>
                    <select class="form-control" name="shipping_method_id" id="shipping_method_id">
                        @foreach ($shippingMethods as $method)
                            <option value="{{ $method->getId() }}" {{ $method->getId() == old('shipping_method_id')  ? 'selected' : '' }}>
                                {{ $method->getName() }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('theme', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group {{ $errors->has('shipping_storage_id') ? 'has-error' : '' }}">
                    <label for="shipping_storage_id">{{ trans('product::basicproducts.shipping_storage') }}</label>
                    <select class="form-control" name="shipping_storage_id" id="shipping_storage_id">
                        @foreach ($storages as $storage)
                            <option value="{{ $storage->id }}" {{ $storage->id == old('shipping_storage_id')  ? 'selected' : '' }}>
                                {{ $storage->name }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('theme', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

    </div>
    <!-- /.box-body -->
</div>
