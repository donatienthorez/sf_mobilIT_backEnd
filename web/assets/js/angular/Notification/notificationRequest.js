adminModule.service('notificationRequest', NotificationRequest);

NotificationRequest.$inject = [
    '$http'
];

function NotificationRequest($http) {
    var ctrl = this;

    ctrl.getNotifications = getNotifications;
    ctrl.getSections = getSections;
    ctrl.sendNotification = sendNotification;

    /**
     * Retrieve notifications of the section.
     *
     * @return promise.
     */
    function getNotifications() {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_notifications_list'
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Retrieve all the sections.
     *
     * @return promise.
     */
    function getSections() {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_sections_get'
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Send notifications of the section.
     *
     * @return promise.
     */
    function sendNotification(notification, sections) {
        notification.sections = sections;
        return $http({
            method: 'POST',
            url: Routing.generate(
                'api_notifications_send',
                notification
            )
        }).then(function (result) {
            return result.data;
        });
    }
}
