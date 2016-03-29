adminModule.controller('sectionController', SectionController);

SectionController.$inject = [
    'sectionRequest'
];

function SectionController(sectionRequest) {
    var ctrl = this;

    ctrl.section = {};

    ctrl.init = init;
    ctrl.getSection = getSection;
    ctrl.editSection = editSection;
    ctrl.generateLogoUrl = generateLogoUrl;
    ctrl.changeSectionStatus = changeSectionStatus;

    /**
     * Init the controller by calling getSection
     */
    function init() {
        ctrl.getSection()
    }

    /**
     * Get the section of the logged user
     */
    function getSection() {
        sectionRequest.getSection().then(function (data) {
            ctrl.section = data;
        });
    }

    /**
     * Edit the section
     */
    function editSection() {
        sectionRequest.editSection(ctrl.section).then(function (data) {
            ctrl.section = data;
        });
    }

    /**
     * Generate the logo url from the logoInserter
     */
    function generateLogoUrl() {
        sectionRequest.generateLogoUrl(ctrl.section.code_section).then(function (data) {
            ctrl.section.logo_url = data.url;
        });
    }

    /**
     * Change the status of the section
     */
    function changeSectionStatus() {
        sectionRequest.changeSectionStatus().then(function (data) {
            ctrl.section.activated = data;
        });
    }
}
