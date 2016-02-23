settingsModule.service('settingsRequest',
    ['$http',
        function ($http) {
            /**
             * Retrieve section.
             *
             * @return promise.
             */
            this.getSection = function() {
                return $http({
                    method: 'GET',
                    url: Routing.generate(
                        'api_sections_get_of_user'
                    )}).then(function (result) {
                    return result.data;
                });
            };
            /**
             * Generate token for the section.
             *
             * @return promise.
             */
            this.generateToken = function(section) {
                return $http({
                    method: 'POST',
                    url: Routing.generate(
                        'api_sections_generate_token',
                        { section : section }
                    )}
                ).then(function (result) {
                    return result.data;
                });
            };
        }
    ]
);
