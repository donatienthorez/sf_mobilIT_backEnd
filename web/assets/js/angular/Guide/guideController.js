guideModule.controller('guideController',
    ['$scope', 'guideRequest',
        function ($scope, guideRequest) {

            $scope.categorieSelected = {};

            $scope.remove = function (scope) {
                console.log(scope.$modelValue);
                scope.remove();
            };

            $scope.toggle = function (scope) {
                scope.toggle();
                console.log("test");
            };

            $scope.treeOptions = {
                dropped: function(event) {
                    console.log(event.source.nodeScope.$parentNodeScope.$modelValue);
                    console.log(event.dest.nodesScope.$parent.$modelValue);
                    //console.log(event.dest.nodeScope.$parent.$parentNodeScope);
                    //console.log(event);
                    return true;
                }
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

                //parent
                console.log(scope.$modelValue.id);


                nodeData.nodes.push({
                    id: nodeData.id * 10 + nodeData.nodes.length,
                    title: nodeData.title + '.' + (nodeData.nodes.length + 1),
                    nodes: []
                });
            };

            $scope.init = function () {
            };

            $scope.collapseAll = function () {
                $scope.$broadcast('collapseAll');
            };

            $scope.expandAll = function () {
                $scope.$broadcast('expandAll');
            };

            $scope.data = [{
                'id': 1,
                'title': 'node1',
                'content': 'test',
                'nodes': [
                    {
                        'id': 11,
                        'title': 'node1.1',
                        'nodes': [
                            {
                                'id': 111,
                                'title': 'node1.1.1',
                                'nodes': []
                            }
                        ]
                    },
                    {
                        'id': 12,
                        'title': 'node1.2',
                        'nodes': []
                    }
                ]
            }, {
                'id': 2,
                'title': 'node2',
                'nodrop': true, // An arbitrary property to check in custom template for nodrop-enabled
                'nodes': [
                    {
                        'id': 21,
                        'title': 'node2.1',
                        'nodes': []
                    },
                    {
                        'id': 22,
                        'title': 'node2.2',
                        'nodes': []
                    }
                ]
            }, {
                'id': 3,
                'title': 'node3',
                'nodes': [
                    {
                        'id': 31,
                        'title': 'node3.1',
                        'nodes': []
                    }
                ]
            }];
        }]);
