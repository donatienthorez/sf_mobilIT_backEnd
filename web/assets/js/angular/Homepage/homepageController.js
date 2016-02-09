homepageModule.controller('homepageController',
    ['$scope', 'homepageRequest',
        function ($scope, homepageRequest) {
            $scope.notifications = 0;
            $scope.guides = 0;
            $scope.regids = 0;

            $scope.init = function () {
                $scope.getNotificationsCount();
                $scope.getGuidesCount();
                $scope.getRegIdsCount();
            };

            $scope.getNotificationsCount = function() {
                homepageRequest.getNotificationsCount().then(function (data){
                    animateToValue(data, 'layout_notifications')
                });

            };

            $scope.getGuidesCount = function() {
                homepageRequest.getGuidesCount().then(function (data){
                    animateToValue(data, 'layout_guides')
                });
            };

            $scope.getRegIdsCount = function() {
                homepageRequest.getRegIdsCount().then(function (data){
                    animateToValue(data, 'layout_users')
                });
            };

            function animateToValue(value, id_layout) {
                $({someValue: 0}).animate({someValue: value}, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $('#' + id_layout).text(commaSeparateNumber(Math.round(this.someValue)));
                    }
                });
            }

            function commaSeparateNumber(val) {
                while (/(\d+)(\d{3})/.test(val.toString())) {
                    val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                }
                return val;
            }
        }
    ]
);
