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
