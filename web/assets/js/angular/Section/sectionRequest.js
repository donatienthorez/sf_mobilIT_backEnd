adminModule.service('sectionRequest', SectionRequest);

SectionRequest.$inject = [
    '$http'
];

function SectionRequest($http) {
    var ctrl = this;

    ctrl.getSection = getSection;
    ctrl.editSection = editSection;
    ctrl.generateLogoUrl = generateLogoUrl;
    ctrl.changeSectionStatus = changeSectionStatus;

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
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Edit section.
     *
     * @return promise.
     */
    function editSection(section) {
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_sections_edit_section',
                {section: section.code_section}
            ),
            data: {
                name: section.name,
                website: section.website,
                email: section.email,
                phone: section.phone,
                university: section.university,
                address: section.address,
                logo_url: section.logo_url
            }
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Generate the logo url from the logoInserter
     *
     * @param section
     *
     * @returns promise
     */
    function generateLogoUrl(section) {
        return $http({
            method: 'GET',
            url: Routing.generate(
                'api_sections_generate_logo_inserter_link',
                {section: section}
            )
        }).then(function (result) {
            return result.data;
        });
    }

    /**
     * Change the status of the section.
     *
     * @return promise.
     */
    function changeSectionStatus() {
        return $http({
            method: 'PUT',
            url: Routing.generate(
                'api_sections_change_status'
            )
        }).then(function (result) {
            return result.data;
        });
    }
}
