adminModule.service('guideRequest', GuideRequest);

GuideRequest.$inject = ['$http'];

function GuideRequest($http) {
    var ctrl = this;

    ctrl.getGuide = getGuide;
    ctrl.addChildCategory = addChildCategory;
    ctrl.addCategory = addCategory;
    ctrl.changeGuideStatus = changeGuideStatus;
    ctrl.moveCategory = moveCategory;
    ctrl.removeCategory = removeCategory;
    ctrl.deleteImage = deleteImage;
    ctrl.save = save;

    /**
     * Retrieve the guide.
     *
     * @return promise.
     */
    function getGuide() {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_guides_list'
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Add a child to a category.
     *
     * @return promise.
     */
    function addChildCategory(category) {
        return $http({
            method: 'POST',
            url: Routing.generate(
                'api_categories_add_child',
                {'category': category}
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Add a child category to a guide.
     *
     * @return promise.
     */
    function addCategory() {
        return $http({
            method: 'POST',
            url: Routing.generate(
                'api_categories_add'
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Change the status of the guide.
     *
     * @return promise.
     */
    function changeGuideStatus() {
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_guides_change_status'
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Move a category.
     *
     * @return promise.
     */
    function moveCategory(category, oldParent, newParent, position) {
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_categories_move_category',
                {'category': category}
            ),
            data: {
                'oldParentId': oldParent,
                'newParentId': newParent,
                'position': position
            }
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Delete a category.
     *
     * @return promise.
     */
    function removeCategory(category) {
        return $http({
            method: 'DELETE',
            url: Routing.generate(
                'api_categories_remove',
                {'category': category}
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Save a category.
     *
     * @return promise.
     */
    function save(category) {
        var url = Routing.generate(
            'api_categories_edit_category',
            {'category': category.id});
        var formData = new FormData();
        formData.append('image', category.file);
        formData.append('title', category.title);
        if (null != category.content) {
            formData.append('content', category.content);
        } else {
            formData.append('content', "");
        }

        $http.post(url, formData, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        })
        .success(function(data) {
            category.image = data.image;
        })
        .error(function(data) {
            //@TODO: something unique here for an error message
        });
    }

    /**
     * Delete the image of a category.
     *
     * @return promise.
     */
    function deleteImage(category) {
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_categories_delete_image',
                {'category': category.id}
            )
        }).then(function (result) {
        });
    }
}
