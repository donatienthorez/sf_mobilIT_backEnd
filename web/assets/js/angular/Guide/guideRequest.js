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
}]);