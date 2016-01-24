notificationModule.controller('notificationController',
    ['$scope', 'notificationRequest',
        function ($scope, notificationRequest) {
            $scope.notifications = [];
            $scope.notification = {};

            // this will be deleted when the getSectionFromUser api will be done
            $scope.lille = { "name":"ESN Lille", "code_section":"FR-LILL-ESL"};

            $scope.sectionsSelected = [];
            $scope.sections = [];

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
                var sectionsToSend = [];
                angular.forEach($scope.sectionsSelected, function(section, key) {
                    sectionsToSend.push(section.code_section);
                });
                notificationRequest.sendNotification(
                    $scope.notification,
                    sectionsToSend
                ).then(function (data) {
                    $scope.notifications.splice(0, 0, data);
                });
            }
        }
    ]
);
