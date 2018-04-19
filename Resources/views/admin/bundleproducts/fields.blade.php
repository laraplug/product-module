<div class="box box-primary" id="bundle" ng-app="bundle" ng-controller="BundleController">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('product::bundleproducts.title.add product') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td width="10%" class="text-center">{{ trans('product::products.image') }}</td>
                    <td width="15%" class="text-center">{{ trans('product::products.name') }}</td>
                    <td width="30%" class="text-center">{{ trans('product::options.title.options') }}</td>
                    <td width="10%" class="text-center">{{ trans('product::products.price') }}</td>
                    <td width="10%" class="text-center">{{ trans('product::bundleproducts.quantity') }}</td>
                    <td width="10%" class="text-center">{{ trans('product::bundleproducts.total') }}</td>
                    <td width="5%" class="text-center">{{ trans('core::core.table.actions') }}</td>
                </tr>
            </thead>
            <tbody>
                <tr index="$index" ng-repeat="item in bundleItems">
                    <td>
                        <img ng-src="{% item.product.small_thumb %}" />
                    </td>
                    <td>
                        {% item.product.name %}
                    </td>
                    <td>
                        <div class="row" ng-repeat="option in item.product.options">
                            <input type="hidden"
                                name="items[{% $index %}][product_id]"
                                ng-value="item.product.id" />

                            <label class="col-sm-2">
                              <input type="checkbox"
                                  ng-true-value="1" ng-false-value="0"
                                  ng-model="item.options[option.id].enabled">
                            </label>
                            <div class="col-sm-10 form-group">
                                <label>{% option.name %}</label>
                                <div compile="option.form_field"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        {% item.price %}
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            placeholder="{{ trans('product::bundleproducts.quantity') }}"
                            ng-model="item.quantity"
                            ng-value="item.quantity"
                            name="items[{% $index %}][quantity]" />
                    </td>
                    <td>
                        {% item.price_total %}
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-flat" ng-click="removeBundleItem(option, $index)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <selectize placeholder="{{ trans('product::bundleproducts.messages.search to add product') }}" config="selectizeConfig" ng-model="productId"></selectize>
    </div>
    <!-- /.box-footer -->
</div>

@push('js-stack')
    {!! Theme::script('vendor/admin-lte/plugins/datepicker/bootstrap-datepicker.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js"></script>
    <script src="{{ Module::asset('product:js/ng-components/selectize.directive.js') }}"></script>
    <script>
    angular.module('bundle', [
        'selectize'
    ])
    .config(function($interpolateProvider) {
      $interpolateProvider.startSymbol('{%');
      $interpolateProvider.endSymbol('%}');
    })
    .controller('BundleController', function($scope) {

        $scope.bundleItems = [];

        $scope.addBundleItem = function(item) {
            if(!item['product']) return;
            if(!$scope.bundleItems) $scope.bundleItems = [];
            console.log(item);

            // 옵션은 존재하면 enabled처리
            for(var optionId in item.options) {
                item.options[optionId].enabled = 1;
            }

            item.product.options.map(function(option) {
                option.form_field = option.form_field.replace('name="options[', 'name="items[{% $index %}][options][');
                option.form_field = option.form_field.replace('name=', 'ng-model="item.options[option.id].value" ng-disabled="!item.options[option.id].enabled" name=');
                console.log(option);
                return option;
            });

            $scope.bundleItems.push(item);
        };

        // Retrieve data from db
        var savedItems = {!! old('items',
            $product->items->map(function($item) {
                $data = $item->toArray();
                $data['options'] = $item->options->keyBy('product_option_id');
                return $data;
            })->toJson()
        ) !!};
        savedItems.map(function(item) {
            $scope.addBundleItem(item);
        });
        console.log($scope.bundleItems);

        // selectize
        $scope.selectizeConfig = {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            create: false,
            onItemAdd: function(value, $item) {
                var product = this.options[value];

                $scope.addBundleItem({'product':product});

                this.clear();
            },
            render: {
                option: function(item, escape) {
                    return '<div>' +
                        '<span class="title">' +
                            '<span class="name">' + escape(item.name) + '</span>' +
                        '</span>' +
                    '</div>';
                }
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: route('api.product.products.indexServerSide') + '?search=' + encodeURIComponent(query),
                    type: 'GET',
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res.data);
                    }
                });
            }
        };

    })
    .directive('compile', ['$compile', function ($compile) {
      return function(scope, element, attrs) {
        scope.$watch(
          function(scope) {
            return scope.$eval(attrs.compile);
          },
          function(value) {
            element.html(value);
            $compile(element.contents())(scope);
          }
       )};
    }]);

    angular.bootstrap(document.getElementById("bundle"), ['bundle']);
    </script>
@endpush
