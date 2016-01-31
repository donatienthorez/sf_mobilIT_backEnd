guideModule.controller('guideController',
    ['$scope', 'guideRequest',
        function ($scope, guideRequest) {
            $scope.categorieSelected = {};
            $scope.section = {};
            $scope.data = [];

            $scope.init = function () {
                getGuide();
            };

            $scope.delete = function (scope) {
                guideRequest.removeCategory(scope.$modelValue.id).then(function (data) {
                    scope.remove();
                });
            };

            $scope.toggle = function (scope) {
                scope.toggle();
                console.log("test");
            };

            $scope.treeOptions = {
                dropped: function(event) {
                    // parent before
                    var sourceParent, destParent;

                    if (event.source.nodesScope.$parent !== null
                        && !angular.isUndefined(event.source.nodesScope.$parent)
                        && !angular.isUndefined(event.source.nodesScope.$parent.$modelValue)
                    ) {
                        sourceParent = event.source.nodesScope.$parent.$modelValue.id;
                    }

                    if (event.dest.nodesScope.$parent !== null
                        && !angular.isUndefined(event.dest.nodesScope.$parent)
                        && !angular.isUndefined(event.dest.nodesScope.$parent.$modelValue)) {
                        destParent = event.dest.nodesScope.$parent.$modelValue.id;
                    }
                    var elementId = event.source.nodeScope.$modelValue.id;
                    var destPosition = event.dest.index;
                    var sourcePosition = event.source.index;

                    if ((sourceParent != destParent || sourcePosition != destPosition)
                        || (sourceParent == undefined && destParent == undefined && sourcePosition != destPosition)
                    ) {
                        console.log("sentRequest");
                        guideRequest.moveCategory(elementId, sourceParent, destParent, destPosition).then(function (data) {
                            return true;
                        });
                    }
                    return false;
                }
            };

            $scope.addToRoot = function () {
              guideRequest.addCategory($scope.section).then(function (data){

              })
            };

            $scope.edit = function (scope) {
                $scope.categorieSelected = scope.$modelValue;
                console.log(scope.$modelValue);
            };

            $scope.moveLastToTheBeginning = function () {

                var a = $scope.data.pop();
                $scope.data.splice(0, 0, a);
            };

            $scope.newSubItem = function (scope) {
                var nodeData = scope.$modelValue;

                console.log(scope.$modelValue.id);
                guideRequest.addChildCategory(scope.$modelValue.id).then(function (data) {
                    nodeData.nodes.push({
                        id: data.id,
                        title: data.title,
                        nodes: []
                    });
                });
            };

            $scope.collapseAll = function () {
                $scope.$broadcast('collapseAll');
            };

            $scope.expandAll = function () {
                $scope.$broadcast('expandAll');
            };

            function getGuide(section) {
                guideRequest.getGuide(section).then(function (data) {
                    $scope.data = data.nodes;
                });
            }
        }]);
