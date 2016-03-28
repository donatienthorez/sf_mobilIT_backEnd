var survivalGuideApp = angular.module('survivalGuideApp', [
    'localytics.directives',
    'admin.module'
]);

survivalGuideApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

var adminModule = angular.module("admin.module", [
    'ui.tree',
    'ngCkeditor',
    'localytics.directives'
]);
