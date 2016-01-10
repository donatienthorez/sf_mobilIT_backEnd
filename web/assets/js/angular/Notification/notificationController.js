notificationModule.controller('notificationController',
    ['$scope', 'notificationRequest',
        function ($scope, notificationRequest) {

            $scope.notifications = [];

            $scope.init = function () {
                getNotifications();
            };

            function getNotifications(section) {
                notificationRequest.getNotifications(section).then(function (data) {
                    $scope.notifications = data;
                });
            }

            $scope.sendNotification = function() {
                notificationRequest.sendNotification($scope.notification, $scope.section).then(function (data) {
                    console.log(data);
                    /** todo add in notifications **/
                    //$scope.notifications = data;
                });
            }
        }
    ]
);
