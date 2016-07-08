survivalGuideApp.controller('guideController', GuideController);

GuideController.$inject = [
    '$scope',
    'guideRequest'
];

function GuideController($scope, guideRequest) {
    var ctrl = this;
    ctrl.data = [];

    ctrl.init = init;
    ctrl.getGuide = getGuide;
    ctrl.remove = remove;
    ctrl.toggle = toggle;
    ctrl.changeGuideStatus = changeGuideStatus;
    ctrl.addToRoot = addToRoot;
    ctrl.edit = edit;
    ctrl.save = save;
    ctrl.moveLastToTheBeginning = moveLastToTheBeginning;
    ctrl.newSubItem = newSubItem;
    ctrl.collapseAll = collapseAll;
    ctrl.expandAll = expandAll;
    ctrl.getGuide = getGuide;
    ctrl.editGuide = editGuide;
    ctrl.deleteImage = deleteImage;

    $scope.editorOptions = {
        language: 'fr',
        uiColor: '#999999'
    };

    $scope.treeOptions = {
        dropped: function(event) {
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
                guideRequest.moveCategory(elementId, sourceParent, destParent, destPosition).then(function (data) {
                    return true;
                });
            }
            return false;
        }
    };

    function init() {
        ctrl.getGuide();
    }

    function remove(scope) {
        guideRequest.removeCategory(scope.$modelValue.id).then(function (data) {
            scope.remove();
        });
    }

    function toggle(scope) {
        scope.toggle();
    }

    function changeGuideStatus() {
        guideRequest.changeGuideStatus().then(function (data) {
            ctrl.activated = data;
        });
    }

    function addToRoot() {
      guideRequest.addCategory().then(function (data){
          if (!ctrl.data) {
              guideRequest.getGuide().then(function (data) {
                  ctrl.activated = data.activated;
                  ctrl.data = data.nodes;
              });
          } else {
              ctrl.data.push({
                  id: data.id,
                  title: data.title,
                  nodes: []
              });
          }
      })
    }

    function edit(scope) {
        ctrl.categorieSelected = scope.$modelValue;
    }

    function save() {
        guideRequest.save(ctrl.categorieSelected);
    }

    function moveLastToTheBeginning() {
        ctrl.data.splice(0, 0, ctrl.data.pop());
    }

    function newSubItem(scope) {
        var nodeData = scope.$modelValue;
        guideRequest.addChildCategory(scope.$modelValue.id).then(function (data) {
            nodeData.nodes.push({
                id: data.id,
                title: data.title,
                nodes: []
            });
        });
    }

    function collapseAll() {
        $scope.$broadcast('collapseAll');
    }

    function expandAll() {
        $scope.$broadcast('expandAll');
    }

    function getGuide() {
        guideRequest.getGuide().then(function (data) {
            ctrl.activated = data.activated;
            ctrl.data = data.nodes;
        });
    }

    function editGuide(category) {
        guideRequest.editGuide(category).then(function (data) {

        })
    }

    function deleteImage(category) {
        guideRequest.deleteImage(category).then(function (data) {
            $('#category-file').value = null;
            delete ctrl.categorieSelected.file;
        })
    }
}
