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

services.factory('DatasetResource', ['$resource', function ($resource) {
    return $resource('/api/1.0/dataset/:id');
}]);

services.factory('Dataset', ['DatasetResource', '$route', '$q', function (DatasetResource, $route, $q) {
    return function () {
        var delay = $q.defer();
        DatasetResource.get({id: $route.current.params.datasetId}, function (dataset) {
            delay.resolve(dataset);
        }, function () {
            delay.reject('Unable to fetch dataset ' + $route.current.params.datasetId);
        });
        return delay.promise;
    };
}]);

services.factory('DatasetHolder', function () {
    var savedDatasets;

    return {
        setDatasets: function (datasets) {
            savedDatasets = datasets;
        },
        getDatasets: function () {
            return savedDatasets;
        },
        resetDatasets: function () {
            savedDatasets.length = 0;
        },
        getKeywords: function () {
            return currentKeywords;
        },
        setKeywords: function (keywords) {
            currentKeywords = keywords;
        }
    }
});

"use strict";

var app = angular.module('search', ['ngRoute', 'search.directives', 'search.services']);

app.controller('AppCtrl', ['$scope', '$location', '$route', 'Search', 'DatasetHolder', function ($scope, $location, $route, Search, DatasetHolder) {
    $scope.search = function () {
        $scope.$emit('search:start');
        $scope.datasets = Search.query({keywords: $scope.keywords}, function (datasets, responseHeaders) {
            DatasetHolder.setDatasets(datasets);
            $location.path('/search/' + $scope.keywords);
            $scope.$emit('search:end');
        });
    }
}]);

app.controller('SearchCtrl', ['$scope', '$route', 'DatasetHolder', function ($scope, $route, DatasetHolder) {
    $scope.keywords = $route.current.params.keywords;
    $scope.datasets = DatasetHolder.getDatasets();
}]);

app.controller('DetailCtrl', ['$scope', 'dataset', '$location', 'DatasetHolder', function ($scope, dataset, $location, DatasetHolder) {
    $scope.dataset = dataset;

    $scope.back = function () {
        $location.path('/search/sesia');
    }
}]);

app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
    $routeProvider.
        when('/search/:keywords', {
            controller: 'SearchCtrl',
            templateUrl: '/bundles/pugalodal/js/search/views/search.html'
        }).when('/view/:datasetId', {
            controller: 'DetailCtrl',
            resolve: {
                'dataset': function (Dataset) {
                    return Dataset();
                }
            },
            templateUrl: '/bundles/pugalodal/js/search/views/detail.html'
        }).otherwise({redirectTo: '/'});

    $locationProvider.html5Mode(false);
}]);
