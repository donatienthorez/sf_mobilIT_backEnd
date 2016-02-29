sectionsModule.service('sectionsRequest',
    ['$http',
        function ($http) {
            this.generateLogoUrl = function(section) {
                return $http({
                    method: 'GET',
                    url: "http://logoinserter.esnlille.fr/api/" + section
                }).then(function (result) {
                    return result.data;
                });
            };

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
             * Retrieve section.
             *
             * @return promise.
             */
            this.editSection = function(section) {
                console.log(section);
                return $http({
                    method: 'PUT',
                    url: Routing.generate(
                        'api_sections_edit_section',
                        {section : section.code_section}
                    ),
                    data: {
                        name : section.name,
                        website : section.website,
                        email : section.email,
                        phone : section.phone,
                        university : section.university,
                        address : section.address,
                        logo_url : section.logo_url
                    }
                }).then(function (result) {
                    return result.data;
                });
            };
        }
    ]
);
