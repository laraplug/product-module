<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('product::products.title.shipping') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <div class="form-group {{ $errors->has('shipping_method_id') ? 'has-error' : '' }}">
            <label for="shipping_method_id">{{ trans('product::products.shipping_method_id') }}</label>
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
    <!-- /.box-body -->
</div>
