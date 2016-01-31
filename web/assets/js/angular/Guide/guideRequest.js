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
     * Move a category.
     *
     * @return promise.
     */
    this.moveCategory = function(category, oldParent, newParent, position) {
        return $http({
            method: 'POST',
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
}]);