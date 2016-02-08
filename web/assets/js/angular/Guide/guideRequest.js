guideModule.service('guideRequest', ['$http', function ($http) {
    /**
     * Retrieve guide of the section.
     *
     * @return promise.
     */
    this.getGuide = function(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_guides_get',
                {'section': section}
            )}).then(function (result) {
            return result.data;
        });
    };

    /**
     * Add a child to a category.
     *
     * @return promise.
     */
    this.addChildCategory = function(category) {
        return $http({
            method: 'POST',
            url: Routing.generate(
                'api_categories_add_child',
                {'category': category}
            )
        }).then(function (result) {
            return result.data;
        });
    };

    /**
     * Add a child category to a guide.
     *
     * @return promise.
     */
    this.addCategory = function(section) {
        return $http({
            method: 'POST',
            url: Routing.generate(
                'api_categories_add'
            ),
            data: {'section': section}
        }).then(function (result) {
            return result.data;
        });
    };

    /**
     * Change the status of the guide.
     *
     * @return promise.
     */
    this.changeGuideStatus = function(section) {
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_guides_change_status',
                {'section': section}
            )
        }).then(function (result) {
            return result.data;
        });
    };

    /**
     * Move a category.
     *
     * @return promise.
     */
    this.moveCategory = function(category, oldParent, newParent, position) {
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_categories_move_category',
                {'category': category}
            ),
            data: {'oldParentId': oldParent, 'newParentId': newParent, 'position': position}
        }).then(function (result) {
            return result.data;
        });
    };

    /**
     * Delete a category.
     *
     * @return promise.
     */
    this.removeCategory = function(category) {
        return $http({
            method: 'DELETE',
            url: Routing.generate(
                'api_categories_remove',
                {'category': category}
            )
        }).then(function (result) {
            return result.data;
        });
    };

    /**
     * Save a category.
     *
     * @return promise.
     */
    this.save = function(category) {
        console.log(category.id);
        console.log(category.title);
        console.log(category.content);
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_categories_edit_category',
                {'category': category.id}
            ),
            data: {'content': category.content, 'title': category.title}
        }).then(function (result) {
            return result.data;
        });
    };
}]);