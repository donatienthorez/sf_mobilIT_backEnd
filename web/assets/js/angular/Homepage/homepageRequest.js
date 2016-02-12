homepageModule.service('homepageRequest', ['$http', function ($http) {
    /**
     * Retrieve the count notifications.
     *
     * @return promise.
     */
    this.getNotificationsCount = function(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_notifications_count'
            )}).then(function (result) {
            return result.data;
        });
    };

    /**
     * Retrieve the count regIds.
     *
     * @return promise.
     */
    this.getRegIdsCount = function(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_regids_count'
            )}).then(function (result) {
            return result.data;
        });
    };
    /**
     * Retrieve the count guides.
     *
     * @return promise.
     */
    this.getGuidesCount = function(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_guides_count'
            )}).then(function (result) {
            return result.data;
        });
    };
}]);