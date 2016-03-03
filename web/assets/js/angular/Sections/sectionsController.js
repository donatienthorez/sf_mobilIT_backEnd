settingsModule.controller('sectionsController',
    ['$scope', 'sectionsRequest',
        function ($scope, sectionsRequest) {
            $scope.section = {};

            $scope.init = function () {
                $scope.getSection()
            };

            $scope.getSection = function () {
                sectionsRequest.getSection().then(function (data) {
                    $scope.section = data;
                });
            };

            $scope.editSection = function () {
                sectionsRequest.editSection($scope.section).then(function (data) {
                    $scope.section = data;
                });
            };

            $scope.generateLogoUrl = function() {
                sectionsRequest.generateLogoUrl($scope.section.code_section).then(function (data) {
                    $scope.section.logo_url = data.url;
                });
            }
        }
    ]
);
