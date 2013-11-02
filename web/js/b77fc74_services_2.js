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
