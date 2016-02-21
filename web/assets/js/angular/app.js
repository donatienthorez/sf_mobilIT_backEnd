var survivalGuideApp = angular.module('survivalGuideApp', [
    'homepage.module',
    'notification.module',
    'settings.module',
    'guide.module',
    'localytics.directives'
]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

var notificationModule = angular.module("notification.module", ['localytics.directives']);
var guideModule = angular.module("guide.module", ['ui.tree', 'ngCkeditor']);
var homepageModule = angular.module("homepage.module", []);
var settingsModule = angular.module("settings.module", []);
