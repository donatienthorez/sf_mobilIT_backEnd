notificationModule.controller('notificationController',
    ['$scope', 'notificationRequest',
        function ($scope, notificationRequest) {
            $scope.notifications = [];
            $scope.notification = {};
            $scope.sections = ["FR-LILL-ESL", "FR-PARI-ESL" ];

            $scope.init = function () {
                getNotifications();
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
