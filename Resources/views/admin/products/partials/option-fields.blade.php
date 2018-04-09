<div class="box box-primary" ng-app="app" ng-controller="ProductController as product">
    <div class="box-header with-border">
        <h4 class="box-title">{{ trans('product::products.title.options') }}</h4>
    </div>
    <div class="box-body">
        <div class="form-group">

            <uib-tabset>
                <uib-tab sortable-tab index="$index" ng-repeat="option in options" heading="{% option.name %}">
                    <input type="hidden"
                        name="options[{% option.slug %}][type]"
                        ng-value="option.type">

                    <input type="hidden"
                        name="options[{% option.slug %}][sort_order]"
                        ng-value="$index">

                    <div class="row">
                        <div class="col-sm-6">
                            <label>
                              <input type="checkbox"
                                  icheck checkbox-class="icheckbox_flat-blue"
                                  ng-true-value="1" ng-false-value="0"
                                  ng-model="option.required">
                                  {{trans('product::options.form.required')}}

                                <input type="hidden"
                                    name="options[{% option.slug %}][required]"
                                    ng-value="option.required" />
                            </label>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a class="btn btn-danger btn-xs" ng-click="deleteOption($index)">
                                {{ trans('product::options.button.delete option') }}
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>{{ trans('product::options.form.slug') }}</label>
                            <input type="text" class="form-control"
                                placeholder="{{ trans('product::options.form.slug') }}"
                                ng-value="option.slug"
                                ng-model="option.slug"
                                name="options[{% option.slug %}][slug]">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{ trans('product::options.form.name') }}</label>
                            <input type="text" class="form-control"
                                placeholder="{{ trans('product::options.form.name') }}"
                                ng-value="option.name"
                                ng-model="option.name"
                                name="options[{% option.slug %}][name]">
                        </div>
                    </div>

                    <div ng-include="option.is_collection ? 'collectionValue.tmpl' : 'singleValue.tmpl'">

                    </div>

                </uib-tab>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;" aria-expanded="false">
                      {{ trans('product::options.button.create option') }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li ng-repeat="type in optionTypes" role="presentation">
                            <a role="menuitem" tabindex="-1" href="javascript:;" ng-click="addOption(type)">{% type.type_name %}</a>
                        </li>
                    </ul>
                </li>
            </uib-tabset>

        </div>
    </div>

    <script type="text/ng-template" id="singleValue.tmpl">

    </script>

    <script type="text/ng-template" id="collectionValue.tmpl">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <tr>
                    <td width="10%" class="text-center">{{ trans('product::optionvalues.form.code') }}</td>
                    <td width="20%" class="text-center">{{ trans('product::optionvalues.form.name') }}</td>
                    <td width="15%" class="text-center">{{ trans('product::optionvalues.form.stock_enabled') }}</td>
                    <td width="10%" class="text-center">{{ trans('product::optionvalues.form.stock_quantity') }}</td>
                    <td width="15%" class="text-center">{{ trans('product::optionvalues.form.price_type') }}</td>
                    <td width="10%" class="text-center">{{ trans('product::optionvalues.form.price_value') }}</td>
                    <td width="10%" class="text-center">{{ trans('product::optionvalues.form.calculated_price') }}</td>
                    <td width="5%" class="text-center">{{ trans('core::core.table.actions') }}</td>
                </tr>
            </thead>
            <tbody>
                <tr index="$index" ng-repeat="value in option.values">
                    <td>
                        <input type="text" class="form-control"
                            placeholder="{{ trans('product::optionvalues.form.code') }}"
                            ng-model="value.code"
                            ng-value="value.code"
                            ng-readonly="option.is_system"
                            name="options[{% option.slug %}][values][{% value.code %}][code]">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            placeholder="{{ trans('product::optionvalues.form.name') }}"
                            ng-model="value.name"
                            ng-value="value.name"
                            name="options[{% option.slug %}][values][{% value.code %}][name]">
                    </td>
                    <td>
                        <select class="form-control"
                        ng-model="value.stock_enabled"
                        ng-value="value.stock_enabled"
                        name="options[{% option.slug %}][values][{% value.code %}][stock_enabled]">
                            <option ng-value="0">{{ trans('product::optionvalues.stock_enabled.false') }}</option>
                            <option ng-value="1">{{ trans('product::optionvalues.stock_enabled.true') }}</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            placeholder="{{ trans('product::optionvalues.form.stock_quantity') }}"
                            ng-model="value.stock_quantity"
                            ng-value="value.stock_quantity"
                            name="options[{% option.slug %}][values][{% value.code %}][stock_quantity]">
                    </td>
                    <td>
                        <select class="form-control"
                            ng-model="value.price_type"
                            ng-value="value.price_type"
                            ng-change="calcOptionValuePrice(value)"
                            name="options[{% option.slug %}][values][{% value.code %}][price_type]">
                                <option value="FIXED">{{ trans('product::optionvalues.price_type.fixed') }}</option>
                                <option value="PERCENTAGE">{{ trans('product::optionvalues.price_type.percentage') }}</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            placeholder="{{ trans('product::optionvalues.form.price_value') }}"
                            ng-model="value.price_value"
                            ng-value="value.price_value"
                            ng-init="calcOptionValuePrice(value)"
                            ng-change="calcOptionValuePrice(value)"
                            name="options[{% option.slug %}][values][{% value.code %}][price_value]">
                    </td>
                    <td>
                        {% value['price_total'] %}
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-flat" ng-click="removeOptionValue(option, $index)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td>
                        <button type="button" class="btn btn-default btn-flat" ng-click="addOptionValue(option)">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </script>

</div>

@push('css-stack')
<style>
[ng-app="app"] .tab-pane {
  padding: 10px;
}
</style>
@endpush

@push('js-stack')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.min.js"></script>
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

        $scope.optionTypes = {!! $optionTypes->toJson() !!};
        console.log($scope.optionTypes);
        $scope.options = {!! json_encode( old('options', $product->options) , JSON_NUMERIC_CHECK) !!};
        console.log($scope.options);

        var getHash = function() {
            return Math.random().toString(36).substring(7);
        };

        $scope.addOption = function(type) {
            $scope.options.push({
                'type': type.type,
                'slug':  type.type + '-' + getHash(),
                'name': 'NEW Option',
                'is_collection': type.is_collection
            });
            console.log(type);
        };

        $scope.deleteOption = function(index) {
            $scope.options.splice(index, 1);
        };

        $scope.addOptionValue = function(option) {
            if(!option.values) option.values = [];

            option.values.push({
                'code': getHash(),
                'stock_enabled': 0,
                'stock_quantity': 0,
                'price_type': 'FIXED',
                'price_value': 0,
            });
            console.log(option.values);
        };

        $scope.calcOptionValuePrice = function(item) {
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

    })
    .directive('sortableTab', function($timeout, $document) {
    // https://stackoverflow.com/questions/22850782/angular-tabs-sortable-moveable
      return {
        link: function(scope, element, attrs, controller) {
          // Attempt to integrate with ngRepeat
          // https://github.com/angular/angular.js/blob/master/src/ng/directive/ngRepeat.js#L211
          var match = attrs.ngRepeat.match(/^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?\s*$/);
          var tabs;
          scope.$watch(match[2], function(newTabs) {
            tabs = newTabs;
          });

          var index = scope.$index;
          scope.$watch('$index', function(newIndex) {
            index = newIndex;
          });

          attrs.$set('draggable', true);

          // Wrapped in $apply so Angular reacts to changes
          var wrappedListeners = {
            // On item being dragged
            dragstart: function(e) {
              e = (e.originalEvent || e);
              e.dataTransfer.effectAllowed = 'move';
              e.dataTransfer.dropEffect = 'move';
              e.dataTransfer.setData('application/json', index);
              element.addClass('dragging');
            },
            dragend: function(e) {
              //e.stopPropagation();
              element.removeClass('dragging');
            },

            // On item being dragged over / dropped onto
            dragenter: function(e) {
            },
            dragleave: function(e) {
              element.removeClass('hover');
            },
            drop: function(e) {
              e = (e.originalEvent || e);
              e.preventDefault();
              e.stopPropagation();
              var sourceIndex = e.dataTransfer.getData('application/json');
              move(sourceIndex, index);
              element.removeClass('hover');
            }
          };

          // For performance purposes, do not
          // call $apply for these
          var unwrappedListeners = {
            dragover: function(e) {
              e.preventDefault();
              element.addClass('hover');
            },
            /* Use .hover instead of :hover. :hover doesn't play well with
               moving DOM from under mouse when hovered */
            mouseenter: function() {
              element.addClass('hover');
            },
            mouseleave: function() {
              element.removeClass('hover');
            }
          };

          angular.forEach(wrappedListeners, function(listener, event) {
            element.on(event, wrap(listener));
          });

          angular.forEach(unwrappedListeners, function(listener, event) {
            element.on(event, listener);
          });

          function wrap(fn) {
            return function(e) {
              scope.$apply(function() {
                fn(e);
              });
            };
          }

          function move(fromIndex, toIndex) {
            // http://stackoverflow.com/a/7180095/1319998
            tabs.splice(toIndex, 0, tabs.splice(fromIndex, 1)[0]);
          };

        }
      }
    });
    </script>
@endpush
