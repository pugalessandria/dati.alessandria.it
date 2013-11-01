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

"use strict";

var services = angular.module('search.services', ['ngResource']);

services.factory('Search', ['$resource', function ($resource) {
    return $resource('/api/1.0/search');
}]);

services.factory('Dataset', ['$resource', function ($resource) {
    return $resource('/api/1.0/dataset/:id');
}]);

services.factory('DatasetLoader', ['Dataset', '$route', '$q', function (Dataset, $route, $q) {
    return function () {
        var delay = $q.defer();
        Dataset.get({id: $route.current.params.datasetId}, function (dataset) {
            delay.resolve(dataset);
        }, function () {
            delay.reject('Unable to fetch dataset ' + $route.current.params.datasetId);
        });
        return delay.promise;
    };
}]);

"use strict";

var app = angular.module('search', ['ngRoute', 'search.directives', 'search.services']);

app.controller('SearchCtrl', ['$scope', 'Search', '$rootScope', function ($scope, Search, $rootScope) {
    $scope.search = function () {
        $rootScope.$broadcast('search:start');
        $scope.results = Search.query({keywords: $scope.keywords}, function () {
            $rootScope.$broadcast('search:end');
        });
    }
}]);

app.controller('DetailCtrl', ['$scope', 'dataset', '$location', function ($scope, dataset, $location) {
    $scope.dataset = dataset;

    $scope.back = function () {
        $location.path('/');
    }
}]);

app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.
        when('/', {
            controller: 'SearchCtrl',
            templateUrl: '/bundles/pugalodal/js/search/views/search.html'
        }).when('/view/:datasetId', {
            controller: 'DetailCtrl',
            resolve: {
                dataset: function (DatasetLoader) {
                    return DatasetLoader();
                }
            },
            templateUrl: '/bundles/pugalodal/js/search/views/detail.html'
        }).otherwise({redirectTo: '/'});
}]);
