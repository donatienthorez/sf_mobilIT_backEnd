adminModule.controller('homepageController', HomepageController);

HomepageController.$inject = [
    'homepageRequest'
];

function HomepageController(homepageRequest) {
    var ctrl = this;

    ctrl.notifications = 0;
    ctrl.guides = 0;
    ctrl.regids = 0;

    ctrl.init = init;
    ctrl.getNotificationsCount = getNotificationsCount;
    ctrl.getGuidesCount = getGuidesCount;
    ctrl.getRegIdsCount = getRegIdsCount;

    function init() {
        ctrl.getNotificationsCount();
        ctrl.getGuidesCount();
        ctrl.getRegIdsCount();
    }

    function getNotificationsCount() {
        homepageRequest.getNotificationsCount().then(function (data) {
            animateToValue(data, 'layout_notifications')
        });
    }

    function getGuidesCount() {
        homepageRequest.getGuidesCount().then(function (data) {
            animateToValue(data, 'layout_guides')
        });
    }

    function getRegIdsCount() {
        homepageRequest.getRegIdsCount().then(function (data) {
            animateToValue(data, 'layout_users')
        });
    }

    function animateToValue(value, id_layout) {
        $({someValue: 0}).animate({someValue: value}, {
            duration: 2000,
            easing: 'swing',
            step: function () {
                $('#' + id_layout).text(
                    commaSeparateNumber(Math.round(this.someValue))
                );
            }
        });
    }

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        return val;
    }
}