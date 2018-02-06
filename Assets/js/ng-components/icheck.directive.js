angular.module('app.directive.icheck', [])
.directive('icheck', function($timeout, $parse) {
    return {
        require: 'ngModel',
        link: function($scope, element, $attrs, ngModel) {
            return $timeout(function() {
                var value = $attrs['value'];
                $scope.$watch($attrs['ngModel'], function(newValue){
                    $(element).iCheck('update');
                })

                $scope.$watch($attrs['ngDisabled'], function(newValue) {
                    $(element).iCheck(newValue ? 'disable':'enable');
                    $(element).iCheck('update');
                })

                return $(element).iCheck({
                    checkboxClass: $attrs['checkboxClass'] ? $attrs['checkboxClass'] : 'icheckbox_minimal',
                    radioClass: $attrs['radioClass'] ? $attrs['radioClass'] : 'icheckbox_minimal'
                }).on('ifToggled', function(event) {
                    if ($(element).attr('type') === 'checkbox' && $attrs['ngModel']) {
                        $scope.$apply(function() {
                            return ngModel.$setViewValue(event.target.checked);
                        });
                    }
                    if ($(element).attr('type') === 'radio' && $attrs['ngModel']) {
                        return $scope.$apply(function() {
                            return ngModel.$setViewValue(value);
                        });
                    }
                });
            });
        }
    };
});
