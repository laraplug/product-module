@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('product::products.create resource') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.product.product.index') }}">{{ trans('product::products.title.products') }}</a></li>
        <li class="active">{{ trans('product::products.create resource') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.product.product.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('product::admin.products.partials.create-trans-fields', ['lang' => $locale])

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
                            {!! Form::normalInput('regular_price', trans('product::products.regular_price'), $errors, (object)['regular_price'=>0]) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::normalInput('sale_price', trans('product::products.sale_price'), $errors, (object)['sale_price'=>0]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group {{ $errors->has('currency_code') ? 'has-error' : '' }}">
                                <label for="currency_code">{{ trans('product::products.currency_code') }}</label>
                                <select class="selectize" name="currency_code" id="currency_code">
                                    @foreach ($currencyCodes as $code => $currency)
                                        <option value="{{ $code }}" {{ $code == old('currency_code', trans('product::products.currency.code'))  ? 'selected' : '' }}>
                                            {{ Lang::has("product::products.currencies.$code") ? trans("product::products.currencies.$code") : $currency['name'] }}
                                            &nbsp; {{ $currency['symbol'] }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('currency_code', '<span class="help-block">:message</span>') !!}
                            </div>
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
                    @attributes($currentType->getEntityNamespace(), $currentType)
                </div>
            </div>

            <!-- Product Options -->
            @include('product::admin.products.partials.option-fields', ['product' => $currentType, 'attributes' => $currentType->attributes()->get(), 'options' => collect()])

        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        <label for="type">{{ trans('product::products.type') }}</label>
                        <select class="form-control" name="type" id="type">
                            @foreach ($productTypes as $type)
                                <option value="{{ $type->getEntityNamespace() }}" {{ $type->getEntityNamespace() == old('type', $currentType->getEntityNamespace())  ? 'selected' : '' }}>
                                    {{ trans($type->getEntityName()) }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        <label for="category_id">{{ trans('product::products.category_id') }}</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category_id')  ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
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
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right btn-flat">{{ trans('core::core.button.create') }}</button>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    @tags((new \Modules\Product\Entities\Product())->getEntityNamespace(), null, null, trans('tag::tags.tag'))
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    @mediaSingle('featured_image', null, null, trans('product::products.media.featured_image'))
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    @mediaMultiple('gallery', null, null, trans('product::products.media.gallery'))
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
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
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.tag.tag.index') ?>" }
                ]
            });
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            })
            .on('ifChanged', function(e) {
                // proxy native change
                $(this).trigger('change', e);
            });

            $('select[name=type]').change(function() {
                if(!this.value) return;
                /*
                 * queryParameters -> handles the query string parameters
                 * queryString -> the query string without the fist '?' character
                 * re -> the regular expression
                 * m -> holds the string matching the regular expression
                 */
                var queryParameters = {}, queryString = location.search.substring(1),
                    re = /([^&=]+)=([^&]*)/g, m;

                // Creates a map with the query string parameters
                while (m = re.exec(queryString)) {
                    queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                }

                // Add new parameters or update existing ones
                queryParameters['type'] = this.value;

                /*
                 * Replace the query portion of the URL.
                 * jQuery.param() -> create a serialized representation of an array or
                 *     object, suitable for use in a URL query string or Ajax request.
                 */
                location.search = $.param(queryParameters); // Causes page to reload
            });
        });
    </script>
@endpush
