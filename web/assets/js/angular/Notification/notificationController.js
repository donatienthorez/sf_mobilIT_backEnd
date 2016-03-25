adminModule.controller('notificationController',
    ['$scope', 'notificationRequest',
        function ($scope, notificationRequest) {
            $scope.notifications = [];
            $scope.notification = {};

            $scope.sectionsSelected = [];
            $scope.sections = [];

            $scope.init = function () {
                getNotifications();
                getSections();
            };

            function getNotifications() {
                notificationRequest.getNotifications().then(function (data) {
                    $scope.notifications = data;
                });
            }

            function getSections(){
                notificationRequest.getSections().then(function (data){
                    $scope.sections = data;
                });
            }

            $scope.sendNotification = function() {
                var sectionsToSend = [];
                angular.forEach($scope.sectionsSelected, function(section, key) {
                    sectionsToSend.push(section.code_section);
                });
                notificationRequest.sendNotification(
                    $scope.notification,
                    sectionsToSend
                ).then(function (data) {
                    $scope.notifications.splice(0, 0, data);
                    $scope.notification = {};
                });
            }
        }
    ]
);
