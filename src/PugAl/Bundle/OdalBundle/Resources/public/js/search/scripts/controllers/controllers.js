"use strict";

var app = angular.module('search', ['ngRoute', 'search.directives', 'search.services']);

app.controller('SearchCtrl', ['$scope', '$location', 'DatasetHolder', '$log', function ($scope, $location, DatasetHolder, $log, datasets) {
    $scope.search = function () {
        DatasetHolder.setKeywords($scope.keywords);
        $location.path('/search/' + $scope.keywords);
    }

    $scope.keywords = DatasetHolder.getKeywords();
    //$scope.datasets = datasets;
}]);

app.controller('DetailCtrl', ['$scope', 'dataset', '$location', 'DatasetHolder', function ($scope, dataset, $location, DatasetHolder) {
    $scope.dataset = dataset;

    $scope.back = function () {
        $location.path('/');
    }
}]);

app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
    $routeProvider.
        when('/', {
            controller: 'SearchCtrl',
            templateUrl: '/bundles/pugalodal/js/search/views/search.html'
        }).when('/search/:keywords', {
            controller: 'SearchCtrl',
            resolve: {
                datasets: function (Searcher) {
                    return Searcher();
                }
            },
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

    $locationProvider.html5Mode(false);
}]);
