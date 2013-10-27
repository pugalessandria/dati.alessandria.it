"use strict";

var app = angular.module('search', ['ngRoute', 'search.directives', 'search.services']);

app.controller('SearchCtrl', ['$scope', 'Search', '$rootScope', function ($scope, Search, $rootScope) {
    $scope.search = function () {
        $rootScope.$broadcast('search:start');
        $scope.datasets = Search.query({keywords: $scope.keywords}, function () {
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
