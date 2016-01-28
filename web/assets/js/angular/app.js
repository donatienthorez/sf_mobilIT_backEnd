var survivalGuideApp = angular.module('survivalGuideApp', [
    'notification.module',
    'guide.module',
    'localytics.directives'
]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

var notificationModule = angular.module("notification.module", ['localytics.directives']);
var guideModule = angular.module("guide.module", ['ui.tree']);
