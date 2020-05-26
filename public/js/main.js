'use strict';

/* Controllers */

angular.module('app')
  .controller('AppCtrl', ['$rootScope','$scope','$http', '$translate', '$localStorage', '$window', '$location',
    function($rootScope, $scope,  $http,   $translate,   $localStorage,   $window,$location) {
      // add 'ie' classes to html
      var isIE = !!navigator.userAgent.match(/MSIE/i);
      isIE && angular.element($window.document.body).addClass('ie');
      isSmartDevice( $window ) && angular.element($window.document.body).addClass('smart');

      // config
      $scope.app = {
        name: 'Admin',
        version: '1.3.3',
        // for chart colors
        color: {
          primary: '#7266ba',
          info:    '#23b7e5',
          success: '#27c24c',
          warning: '#fad733',
          danger:  '#f05050',
          light:   '#e8eff0',
          dark:    '#3a3f51',
          black:   '#1c2b36'
        },
        settings: {
          themeID: 11,
          navbarHeaderColor: 'bg-success',
          navbarCollapseColor: 'bg-success',
          asideColor: 'bg-light dker b-r',
          headerFixed: false,
          asideFixed: false,
          asideFolded: false,
          asideDock: false,
          container: false
        }
      }      
      
      $scope.base_url = baseurl;
      $scope.capcha_key = capcha_key;
      
      //check token
      $rootScope.load_sign = function(){
        if ( angular.isDefined($localStorage.token) ) {
          $rootScope.auth_config = {headers: {
            'Authorization': 'Bearer '+$localStorage.token
            }
          }
          $rootScope.auth_config_photo =  {
            'Authorization': 'Bearer '+$localStorage.token,
            'Content-Type': undefined
            }
          $rootScope.auth_config_multi =  {
            'Authorization': 'Bearer '+$localStorage.token        
            }
          //check token ke server
          $http.get(baseurl+'api/session',$scope.auth_config).success(function(response){
            if(response.success){
              if($location.url() == '/access/signin'){
                $location.path('/app/dashboard');
              }
            }else if(response.error){
              delete $localStorage.token;  
              if($location.url() != '/access/signin'){
                $location.path('/access/signin');
              }
            }
          }).error(function(xhr){
            $location.path('/access/signin');
          })
          
        } else {          
          if($location.url() != '/access/signin'){
            $location.path('/access/signin');            
          }
        }
      }      
      $scope.load_sign();
      
      $scope.refresh = function(){
        setTimeout(function() {
          $http.get(baseurl+'api/refresh',$scope.auth_config).success(function(responses){
            $localStorage.token = responses.token
            $rootScope.load_sign();            
          }).error(function(error){
            console.log(error);            
          })
          $scope.refresh()          
        }, 1800000);
      }

      $scope.refresh()


      $scope.logout = function(){        
        delete $localStorage.token;
        
        $scope.load_sign();
      }

      // save settings to local storage
      // if ( angular.isDefined($localStorage.settings) ) {
      //   $scope.app.settings = $localStorage.settings;
      // } else {
      //   $localStorage.settings = $scope.app.settings;
      // }
      // $scope.$watch('app.settings', function(){
      //   if( $scope.app.settings.asideDock  &&  $scope.app.settings.asideFixed ){
      //     // aside dock and fixed must set the header fixed.
      //     $scope.app.settings.headerFixed = false;
      //   }
      //   // save to local storage
      //   $localStorage.settings = $scope.app.settings;
      // }, true);

      // angular translate
      $scope.lang = { isopen: false };
      $scope.langs = {en:'English', de_DE:'German', it_IT:'Italian'};
      $scope.selectLang = $scope.langs[$translate.proposedLanguage()] || "English";
      $scope.setLang = function(langKey, $event) {
        // set the current lang
        $scope.selectLang = $scope.langs[langKey];
        // You can change the language during runtime
        $translate.use(langKey);
        $scope.lang.isopen = !$scope.lang.isopen;
      };

      function isSmartDevice( $window )
      {
          // Adapted from http://www.detectmobilebrowsers.com
          var ua = $window['navigator']['userAgent'] || $window['navigator']['vendor'] || $window['opera'];
          // Checks for iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
          return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua);
      }

  }]);