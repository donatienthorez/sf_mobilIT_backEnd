guideModule.controller('guideController',
    ['$scope', 'guideRequest',
        function ($scope, guideRequest) {
            $scope.categorieSelected = {};
            $scope.section = {};
            $scope.data = [];
            $scope.activated = false;

            $scope.init = function () {
                getGuide();
            };

            $scope.editorOptions = {
                language: 'fr',
                uiColor: '#999999'
            };

            $scope.delete = function (scope) {
                guideRequest.removeCategory(scope.$modelValue.id).then(function (data) {
                    scope.remove();
                });
            };

            $scope.toggle = function (scope) {
                scope.toggle();
            };

            $scope.changeGuideStatus = function (section) {
                guideRequest.changeGuideStatus(section).then(function (data) {
                    $scope.activated = data;
                });
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
                        console.log("elementId: " + elementId);
                        console.log("sourceParent: " + sourceParent);
                        console.log("destParent: " + destParent);
                        console.log("destPosition: " + destPosition);
                        guideRequest.moveCategory(elementId, sourceParent, destParent, destPosition).then(function (data) {
                            return true;
                        });
                    }
                    return false;
                }
            };

            $scope.addToRoot = function () {
              guideRequest.addCategory($scope.section).then(function (data){
                  if (!$scope.data) {
                      guideRequest.getGuide($scope.section).then(function (data) {
                          $scope.activated = data.activated;
                          $scope.data = data.nodes;
                      });
                  } else {
                      $scope.data.push({
                          id: data.id,
                          title: data.title,
                          nodes: []
                      });
                  }
              })
            };

            $scope.edit = function (scope) {
                $scope.categorieSelected = scope.$modelValue;
            };

            $scope.save = function() {
                guideRequest.save($scope.categorieSelected).then(function (data) {

                })
            };

            $scope.moveLastToTheBeginning = function () {

                var a = $scope.data.pop();
                $scope.data.splice(0, 0, a);
            };

            $scope.newSubItem = function (scope) {
                var nodeData = scope.$modelValue;
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
                    $scope.activated = data.activated;
                    $scope.data = data.nodes;
                });
            }

            $scope.editGuide = function(category) {
                guideRequest.editGuide(category).then(function (data) {
                    
                })};
        }]);
