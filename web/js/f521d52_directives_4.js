"use strict";

var directives = angular.module('search.directives', []);

directives.directive('butterbar', ['$rootScope', function ($rootScope) {
    return {
        link: function (scope, element, attrs) {
            element.addClass('hide');

            $rootScope.$on('$routeChangeStart', function () {
                element.removeClass('hide');
            });
            $rootScope.$on('search:start', function () {
                element.removeClass('hide');
            });

            $rootScope.$on('$routeChangeSuccess', function () {
                element.addClass('hide');
            });
            $rootScope.$on('search:end', function () {
                element.addClass('hide');
            });
        }
    };
}]);
