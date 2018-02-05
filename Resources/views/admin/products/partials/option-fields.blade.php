<div class="box box-primary" ng-app="app" ng-controller="ProductController as product">
    <div class="box-header with-border">
        <h4 class="box-title">{{ trans('product::products.title.options') }}</h4>
    </div>
    <div class="box-body">
        @empty ($attributes->filter(function($attribute) { return $attribute->isCollection(); })->all())
            <div class="text-center">
                <h4>{{ trans('product::options.messages.there is no collection type attribute') }}</h4>
            </div>
        @endempty

        @foreach ($attributes as $attribute)
        @continue(!$attribute->isCollection())
        {{-- skip if slug is reserved word --}}
        @if($attribute->slug == 'length')
            <h4>{{ trans('product::options.messages.slug is a reserved word', ['slug' => $attribute->slug]) }}</h4>
            @continue
        @endif
        <div class="form-group">
            <label>
              <input type="checkbox"
              icheck checkbox-class="icheckbox_flat-blue"
              ng-true-value="1" ng-false-value="0"
              ng-model="options['{{ $attribute->slug }}']['enabled']">
              {{ $attribute->name }}

              <input type="hidden"
                  name="options[{{ $attribute->slug }}][enabled]"
                  ng-value="options['{{ $attribute->slug }}']['enabled']" />
            </label>
            <div uib-collapse="!options['{{ $attribute->slug }}'].enabled">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <td width="5%" class="text-center">{{ trans('product::options.form.enable') }}</td>
                            <td width="20%" class="text-center">{{ trans('product::options.form.option_label') }}</td>
                            <td width="15%" class="text-center">{{ trans('product::options.form.stock_enabled') }}</td>
                            <td width="15%" class="text-center">{{ trans('product::options.form.stock_quantity') }}</td>
                            <td width="15%" class="text-center">{{ trans('product::options.form.price_type') }}</td>
                            <td width="15%" class="text-center">{{ trans('product::options.form.price_value') }}</td>
                            <td width="15%" class="text-center">{{ trans('product::options.form.calculated_price') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attribute->options as $key => $option)
                            {{-- skip if $key is reserved word --}}
                            @continue($key == 'length')
                        <tr>
                            <td class="">
                                <input type="checkbox"
                                    icheck checkbox-class="icheckbox_flat-blue"
                                    ng-true-value="1" ng-false-value="0"
                                    ng-model="options['{{ $attribute->slug }}']['values']['{{$key}}']['enabled']"
                                    ng-disabled="!attributes['{{ $attribute->slug }}']['{{$key}}']">

                                    <input type="hidden"
                                        name="options[{{ $attribute->slug }}][values][{{$key}}][enabled]"
                                        ng-value="options['{{ $attribute->slug }}']['values']['{{$key}}']['enabled']" />
                            </td>
                            <td>
                                <p>{{ $option->getLabel() }}</p>
                            </td>
                            <td class="">
                                <select class="form-control"
                                ng-model="options['{{ $attribute->slug }}']['values']['{{$key}}'].stock_enabled"
                                ng-disabled="isOptionDisabled('{{ $attribute->slug }}','{{$key}}')">
                                    <option ng-value="1" selected="selected">{{ trans('product::options.stock_enabled.true') }}</option>
                                    <option ng-value="0">{{ trans('product::options.stock_enabled.false') }}</option>
                                </select>

                                <input type="hidden"
                                    name="options[{{ $attribute->slug }}][values][{{$key}}][stock_enabled]"
                                    ng-value="options['{{ $attribute->slug }}']['values']['{{$key}}'].stock_enabled" />
                            </td>
                            <td class="">
                                <input type="text" class="form-control" placeholder="{{ trans('product::options.form.stock_quantity') }}"
                                    name="options[{{ $attribute->slug }}][values][{{$key}}][stock_quantity]"
                                    ng-model="options['{{ $attribute->slug }}']['values']['{{$key}}'].stock_quantity"
                                    ng-disabled="isOptionDisabled('{{ $attribute->slug }}','{{$key}}') || !options['{{ $attribute->slug }}']['values']['{{$key}}'].stock_enabled">
                            </td>
                            <td class="">
                                <select class="form-control"
                                    name="options[{{ $attribute->slug }}][values][{{$key}}][price_type]"
                                    ng-model="options['{{ $attribute->slug }}']['values']['{{$key}}'].price_type"
                                    ng-change="calcOptionPrice(options['{{ $attribute->slug }}']['values']['{{$key}}'])"
                                    ng-disabled="isOptionDisabled('{{ $attribute->slug }}','{{$key}}')">
                                        <option value="FIXED" selected="selected">{{ trans('product::options.price_type.fixed') }}</option>
                                        <option value="PERCENTAGE">{{ trans('product::options.price_type.percentage') }}</option>
                                </select>
                            </td>
                            <td class="">
                                <input type="text" class="form-control" placeholder="{{ trans('product::options.form.price_value') }}"
                                    name="options[{{ $attribute->slug }}][values][{{$key}}][price_value]"
                                    ng-init="calcOptionPrice(options['{{ $attribute->slug }}']['values']['{{$key}}'])"
                                    ng-model="options['{{ $attribute->slug }}']['values']['{{$key}}'].price_value"
                                    ng-change="calcOptionPrice(options['{{ $attribute->slug }}']['values']['{{$key}}'])"
                                    ng-disabled="isOptionDisabled('{{ $attribute->slug }}','{{$key}}')">
                            </td>
                            <td class="">
                                {% options['{{ $attribute->slug }}']['values']['{{$key}}']['price_total'] %}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('js-stack')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.19.0/sortable.min.js"></script>
    <script src="{{ Module::asset('product:js/ng-components/icheck.directive.js') }}"></script>
    <script>
    angular.module('app', [
        'app.directive.icheck',
        'ui.bootstrap'
    ])
    .config(function($interpolateProvider) {
      $interpolateProvider.startSymbol('{%');
      $interpolateProvider.endSymbol('%}');
    })
    .controller('ProductController', function($scope, $timeout) {

        $scope.attributes = {};

        $scope.options = {!! $options->keyBy('attribute.slug')->toJson() !!};

        // $scope.$watch('options', function(newValue, oldValue)
        // {
        //     console.log('options', $scope['options']);
        // }, true);
        //
        // $scope.$watch('attributes', function(newValue, oldValue)
        // {
        //     console.log('attributes', $scope['attributes']);
        // }, true);

        $scope.applyAttributeChange = function(slug, values) {
            if(!(values instanceof Array)) return;
            $scope.attributes[slug] = {};

            $timeout(function() {
                for(value of values) {
                    $scope.attributes[slug][value] = true;
                }
            });
        };

        $scope.isOptionDisabled = function(slug, attrValue) {
            if($scope.attributes[slug]
                && $scope.attributes[slug][attrValue]
                && $scope.options[slug]
                && $scope.options[slug]['enabled']
                && $scope.options[slug]['values']
                && $scope.options[slug]['values'][attrValue]
                && $scope.options[slug]['values'][attrValue]['enabled']) {
                    return false;
                }
            return true;
        };

        $scope.calcOptionPrice = function(item) {
            if(!item || !item['price_type'] || !$.isNumeric(item['price_value'])) return '-';

            // Start from sale price
            var price = parseInt($('[name=sale_price]').val());
            var priceValue = parseInt(item['price_value']);
            if(item['price_type'] == 'FIXED') {
                price += priceValue;
            }
            else if(item['price_type'] == 'PERCENTAGE') {
                price += Math.round(price * (priceValue / 100));
            }
            item['price_total'] = price;
        };

        // Listen to every attributes input
        $('[name^="attributes"][data-is-collection=1]')
        .on('change', function() {
            var slug = $(this).data('slug');
            var values = $(this).val();

            if($(this).is('[type=checkbox]')) {
                values = [];
                $('[name="'+$(this).attr('name')+'"]:checked')
                .each(function() {
                    values.push($(this).val());
                });
            }

            $scope.applyAttributeChange(slug, values);
        })
        .trigger('change');

    });
    </script>
@endpush
