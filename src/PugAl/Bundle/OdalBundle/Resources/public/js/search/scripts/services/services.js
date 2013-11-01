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
