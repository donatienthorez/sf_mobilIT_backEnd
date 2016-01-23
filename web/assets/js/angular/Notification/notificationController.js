notificationModule.controller('notificationController',
    ['$scope', 'notificationRequest',
        function ($scope, notificationRequest) {
            $scope.notifications = [];
            $scope.notification = {};
            $scope.lille = { "name":"ESN Lille", "code_section":"FR-LILL-ESL"};
            $scope.sectionsSelected = [];

            $scope.sections = [];
            $scope.section = [];

            $scope.init = function () {
                getNotifications($scope.lille.code_section);
                getSections();
            };

            function getNotifications(section) {
                notificationRequest.getNotifications(section).then(function (data) {
                    $scope.notifications = data;
                });
            }

            function getSections(){
                notificationRequest.getSections().then(function (data){
                    $scope.sections = data;
                });
            }

            $scope.sendNotification = function() {
                console.log($scope.sectionsSelected);
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
