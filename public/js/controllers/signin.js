'use strict';

/* Controllers */
  // signin controller
app.controller('SigninFormController', ['$scope', '$http','$localStorage','recaptchaFactory',function($scope, $http, $localStorage,recaptchaFactory) {
    // $cookieStore.remove('auth');
    $scope.load_sign();
  
    $scope['g-recaptcha-response'] = '';

    $scope.user = {};
    $scope.authError = null;
    $scope.success = null;
    $scope.logo = baseurl+'img/logo.png';    
    $scope.loading = false;
    var recaptcha = recaptchaFactory.create('.my-recaptcha', {
      sitekey: capcha_key
    });
    var callbacks = {
        created: function () {
          $scope['g-recaptcha-response'] = '';
        },    
        success: function (response) {          
            $scope['g-recaptcha-response'] = response;          
        },      
        expired: function () {          
            $scope['g-recaptcha-response'] = '';
            recaptcha.reload();
        }
    }
    recaptcha.setConfig(callbacks);
    recaptcha.render();

      $scope.login = function() {
        $scope.loading = true;      
        $scope.success = null;
        $scope.authError = null;
        
        $http.post(baseurl+'api/login', {username: $scope.user.username, password: $scope.user.password,'g-recaptcha-response':$scope['g-recaptcha-response']})
        .then(function(response) {
          $scope.loading = false;          
          if (response.data.token) {    
            $scope.success = 'Login Berhasil';
            $localStorage.token = response.data.token;
            $scope.load_sign();
          }else{        
            $scope.authError = response.data.error;
          }
        }, function(x) {
          $scope.loading = false;
          $scope.authError = x.data.error;
        });
      };


}]);

