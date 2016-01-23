var survivalGuideApp = angular.module('survivalGuideApp', [
    'notification.module',
    'localytics.directives'
]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

var notificationModule = angular.module("notification.module", ['localytics.directives']);
