@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('product::products.edit resource') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.product.product.index') }}">{{ trans('product::products.title.products') }}</a></li>
        <li class="active">{{ trans('product::products.edit resource') }}</li>
    </ol>
@stop

@section('content')
    <div>
    {!! Form::open([
        'route' => ['admin.product.product.update', $product->id],
        'method' => 'put',
        'name' => 'product.form'
    ]) !!}
    <div class="row">
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('product::admin.products.partials.edit-trans-fields', ['lang' => $locale])
                        </div>
                    @endforeach
                </div>
            </div> {{-- end nav-tabs-custom --}}

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ trans('product::products.title.prices') }}</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::normalInput('price', trans('product::products.price'), $errors, $product) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::normalInput('sale_price', trans('product::products.sale_price'), $errors, $product) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ trans('product::products.title.orderlimits') }}</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::normalInput('min_order_limit', trans('product::products.min_order_limit'), $errors, $product) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::normalInput('max_order_limit', trans('product::products.max_order_limit'), $errors, $product) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Attributes -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ trans('product::products.title.attributes') }}</h4>
                </div>
                <div class="box-body">
                    @attributes($product->getEntityNamespace(), $product)
                </div>
            </div>

            <!-- Product Options -->
            @include('product::admin.products.partials.option-fields', ['product' => $product])

            <!-- Product Type Fields -->
            {!! $product->getEntityFields() !!}

        </div>

        <div class="col-md-3">

            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        <label for="type">{{ trans('product::products.type') }}</label>
                        <select class="form-control" name="type" id="type" disabled>
                            <option value="{{ $product->getEntityNamespace() }}" selected>
                                {{ $product->getEntityName() }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        <label for="category_id">{{ trans('product::products.category_id') }}</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}" {{ $id == old('category_id', $product->category_id)  ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                    </div>

                    {!! Form::normalSelect('status', trans('product::products.status'), $errors,
                    [
                        'active' => trans('product::categories.form.status active'),
                        'hide' => trans('product::categories.form.status hide'),
                        'inactive' => trans('product::categories.form.status inactive')
                    ],
                    $product) !!}

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right btn-flat">{{ trans('core::core.button.update') }}</button>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">

                        <div class="form-group {{ $errors->has('shops') ? 'has-error' : '' }}">
                            <label>{{ trans('product::products.shop') }}</label>

                            @foreach ($shops as $shop)
                            <label class="checkbox">
                                <input type="checkbox" name="shops[]"
                                        class="flat-blue"
                                        value="{{ $shop->id }}" {{ in_array($shop->id, old('shops', $product->shops->pluck('id')->all())) ? 'checked' : '' }}>
                                {{ $shop->name }}
                            </label>
                            @endforeach
                            {!! $errors->first('shops', '<span class="help-block">:message</span>') !!}
                        </div>

                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    @tags($product->getEntityNamespace(), $product, null, trans('tag::tags.tag'))
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    @mediaSingle('featured_image', $product, null, trans('product::products.media.featured_image'))
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    @mediaMultiple('gallery', $product, null, trans('product::products.media.gallery'))
                </div>
            </div>

        </div>

    </div>
    {!! Form::close() !!}
    </div>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.selectize').selectize();
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            })
            .on('ifChanged', function(e) {
                // proxy native change
                $(this).trigger('change', e);
            });
        });
    </script>
@endpush
