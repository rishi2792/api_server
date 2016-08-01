angular.module('commentService', [])

    .factory('Comment', function($http) {

        return {
            // get all the comments
            get: function () {
                return $http.get('/api/v1/campaign');
            }

        }


    });