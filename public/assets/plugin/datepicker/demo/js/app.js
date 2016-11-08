(function() {

    'use strict';

    /**
     * Test code for ng-datepicker demo
     */
    angular
        .module('testApp', ['ngFlatDatepicker'])
        .controller('mainController', ['$scope', mainController]);

    function mainController ($scope) {

        $scope.datepickerConfig = {
            dateFormat: 'DD/MM/YYYY',

        };
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 

        today = dd+'/'+mm+'/'+yyyy;
        $scope.date= today;
        
    }   

})();
