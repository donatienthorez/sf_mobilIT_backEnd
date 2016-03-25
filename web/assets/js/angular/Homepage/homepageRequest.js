adminModule.service('homepageRequest', GuideRequest);

GuideRequest.$inject = ['$http'];

function GuideRequest($http) {
    var ctrl = this;

    ctrl.getNotificationsCount = getNotificationsCount;
    ctrl.getRegIdsCount = getRegIdsCount;
    ctrl.getGuidesCount = getGuidesCount;

    /**
     * Retrieve the count notifications.
     *
     * @return promise.
     */
    function getNotificationsCount(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_notifications_count'
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Retrieve the count regIds.
     *
     * @return promise.
     */
    function getRegIdsCount(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_regids_count'
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Retrieve the count guides.
     *
     * @return promise.
     */
    function getGuidesCount(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_guides_count'
            )
        }).then(function (result) {
            return result.data;
        });
    }
}