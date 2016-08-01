
angular.module('mainCtrl', [])

// inject the Comment service into our controller
 .controller('mainCtrl', function($scope, $http, Comment) {
        // object to hold all the data for the new comment form
        $scope.commentData = "hello";

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        // get all the comments first and bind it to the $scope.comments object
        // use the function we created in our service
        // GET ALL COMMENTS ==============


     $scope.student =[ {
         firstName: "rishi",
         lastname: "dutt"
     }]

     // Comment.get()
     //        .success(function (data) {
     //            $scope.campaign = data;
     //            $scope.loading = false;
     //        });
    });