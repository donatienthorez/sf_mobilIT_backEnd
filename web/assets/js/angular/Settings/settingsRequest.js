adminModule.service('settingsRequest', SettingsRequest);

SettingsRequest.$inject = [
    '$http'
];

function SettingsRequest($http) {
    var ctrl = this;

    ctrl.getSection = getSection;
    ctrl.generateToken = generateToken;

    /**
     * Retrieve section.
     *
     * @return promise.
     */
    function getSection() {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_sections_get_of_user'
            )}
        ).then(function (result) {
            return result.data;
        });
    }

    /**
     * Generate token for the section.
     *
     * @return promise.
     */
    function generateToken(section) {
        return $http({
                method: 'POST',
                url: Routing.generate(
                    'api_sections_generate_token',
                    { section : section }
                )}
        ).then(function (result) {
            return result.data;
        });
    }
}
