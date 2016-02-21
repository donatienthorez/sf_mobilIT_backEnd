settingsModule.controller('settingsController',
    ['$scope', 'settingsRequest',
        function ($scope, settingsRequest) {

            $scope.section = {};

            $scope.init = function () {
                $scope.getToken();
            };

            $scope.getToken = function () {
                settingsRequest.getSection().then(function (data) {
                    $scope.section = data;
                });
            };

            $scope.generateToken = function () {
                settingsRequest.generateToken($scope.section.code_section).then(function (data) {
                    $scope.section.token = data;
                });
            };
        }
    ]
);
