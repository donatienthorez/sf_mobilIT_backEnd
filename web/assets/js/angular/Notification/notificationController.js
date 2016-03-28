adminModule.controller('notificationController', NotificationController);

NotificationController.$inject = [
    'notificationRequest'
];

function NotificationController(notificationRequest) {
    var ctrl = this;

    ctrl.notifications = [];
    ctrl.notification = {};
    ctrl.sectionsSelected = [];
    ctrl.sections = [];

    ctrl.init = init;
    ctrl.getNotifications = getNotifications;
    ctrl.getSections = getSections;
    ctrl.sendNotification = sendNotification;

    function init() {
        ctrl.getNotifications();
        ctrl.getSections();
    }

    function getNotifications() {
        notificationRequest.getNotifications().then(function (data) {
            ctrl.notifications = data;
        });
    }

    function getSections() {
        notificationRequest.getSections().then(function (data) {
            ctrl.sections = data;
        });
    }

    function sendNotification() {
        var sectionsToSend = [];
        angular.forEach(ctrl.sectionsSelected, function (section, key) {
            sectionsToSend.push(section.code_section);
        });
        notificationRequest.sendNotification(
            ctrl.notification,
            sectionsToSend
        ).then(function (data) {
                ctrl.notifications.splice(0, 0, data);
                ctrl.notification = {};
            });
    }
}
