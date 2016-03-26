adminModule.controller('settingsController', SettingsController);

SettingsController.$inject = [
    'settingsRequest'
];

function SettingsController(settingsRequest) {
    var ctrl = this;

    ctrl.init = init;
    ctrl.getToken = getToken;
    ctrl.generateToken = generateToken;

    ctrl.section = {};

    /**
     * Init the controller by calling getSection
     */
    function init() {
        ctrl.getToken();
    }

    /**
     * Get the token of a section
     */
    function getToken() {
        settingsRequest.getSection().then(function (data) {
            ctrl.section = data;
        });
    }

    /**
     * Generate a token for a section
     */
    function generateToken() {
        settingsRequest.generateToken(ctrl.section.code_section).then(function (data) {
            ctrl.section.token = data;
        });
    }
}
