var survivalGuideApp = angular.module('survivalGuideApp', [
    'notification.module'
]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

var notificationModule = angular.module("notification.module", []);
