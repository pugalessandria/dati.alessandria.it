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

services.factory('Searcher', ['Search', '$route', '$q', function (Search, $route, $q) {
    return function () {
        var delay = $q.defer();
        Search.query({keywords: $route.current.params.keywords}, function (datasets) {
            delay.resolve(datasets);
        }, function () {
            delay.reject('Unable to fetch dataset ' + $route.current.params.keywords);
        });
        return delay.promise;
    };
}]);

services.factory('DatasetHolder', function () {
        var datasets, currentKeywords;

        return {
            addDataset: function (dataset) {
                return datasets.push(dataset);
            },
            getDataset: function (id) {
                return datasets[id];
            },
            getAllDatasets: function () {
                return datasets;
            },
            resetDatasets: function() {
                datasets.length = 0;
            },
            getKeywords: function() {
                return currentKeywords;
            },
            setKeywords: function(keywords) {
                currentKeywords = keywords;
            }
        }
    });
