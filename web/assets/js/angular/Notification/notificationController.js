notificationModule.controller('notificationController',
    ['$scope', 'notificationRequest',
        function ($scope, notificationRequest) {
            $scope.notifications = [];
            $scope.notification = {};
            $scope.lille = { "name":"ESN Lille", "codeSection":"FR-LILL-ESL"};
            //$scope.paris = { "name":"ESN Paris", "codeSection":"FR-PARI-ESL"};
            $scope.sections = [$scope.lille];

            $scope.init = function () {
                getNotifications($scope.lille.codeSection);
            };

            function getNotifications(section) {
                notificationRequest.getNotifications(section).then(function (data) {
                    $scope.notifications = data;
                });
            }

            $scope.sendNotification = function() {
                notificationRequest.sendNotification(
                    $scope.notification,
                    $scope.sections
                ).then(function (data) {
                    $scope.notifications.splice(0, 0, data);
                });
            }
        }
    ]
);
