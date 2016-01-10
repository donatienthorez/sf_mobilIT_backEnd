notificationModule.service('notificationRequest', ['$http', function ($http) {
    /**
     * Retrieve notifications of the section.
     *
     * @return promise.
     */
    this.getNotifications = function(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_notifications_list',
                {'section': section}
            )}).then(function (result) {
            return result.data;
        });
    };

    /**
     * Send notifications of the section.
     *
     * @return promise.
     */
    this.sendNotification = function(notification, section) {
        if (typeof section != 'undefined') {
            notification.section = section;
        }
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_notifications_send',
                notification
            )}).then(function (result) {
            return result.data;
        });
    };
}]);