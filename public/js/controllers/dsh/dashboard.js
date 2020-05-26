'use strict';


/* Controllers */

app.controller('Dashboard', ['$scope','$http','$modal', '$timeout','toaster', function($scope,$http, $modal,$timeout,toaster) {
  
  $scope.load_sign();
  
  $scope.count = [];
  $http.get(baseurl+'admin/dashboard',$scope.auth_config).success(function(data){
    $scope.count = data;
  });
  
  $http.get(baseurl+'admin/client/record',$scope.auth_config).success(function(data){
    $scope.cc = data;    
  });

}]); 

app.controller('Template', ['$scope','$http', 'toaster', function($scope,$http, toaster) {
  $scope.load_sign();
  $scope.form = {};
  
  $scope.load = true;

  $scope.set_gradient = function(key,your_model){
    $scope.gradient_option[key] = {
      start: your_model,
      count: 10,
      step: 1
    }
  }

  $scope.part = {
    sub1 : {
      name:'Warna Utama',
      color:'#000',
      color_select:'#000'
    },    
    sub2 : {
      name:'Text Warna Utama',
      color:'#000',
      color_select:'#000'
    },    
    sub3 : {
      name:'Warna Konten',
      color:'#000',
      color_select:'#000'
    },
    sub4 : {
      name:'Tulisan Tombol',
      color:'#000',
      color_select:'#000'
    },
    sub5 : {
      name:'Link',
      color:'#000',
      color_select:'#000'
    }
  }
  $scope.set_all = function(color){
    angular.forEach($scope.part,function(value,key) {      
      $scope.part[key].color = color
      $scope.set_gradient(key,color);
    });
  }

  $scope.gradient_option = {
      sub1 : {
        start: $scope.part.sub1.color,
        count: 10,
        step: 1
      },   
      sub2 : {
        start: $scope.part.sub2.color,
        count: 10,
        step: 1
      },    
      sub3 : {
        start: $scope.part.sub3.color,
        count: 10,
        step: 1
      },
      sub4 : {
        start: $scope.part.sub4.color,
        count: 10,
        step: 1
      },
      sub5 : {
        start: $scope.part.sub5.color,
        count: 10,
        step: 1
      }
    }
    $scope.option = {
        size: 35
    }    
  
  $scope.default_color = function(){      
      angular.forEach($scope.data,function(value,key) {        
        if(value.id == $scope.form.id){
          $scope.part = JSON.parse(value.default_style);
          angular.forEach($scope.part,function(value,key) {      
            $scope.part[key].color = $scope.part[key].color
            $scope.set_gradient(key,$scope.part[key].color);
            
          });
        }
      });
  }
    

  $http.get(baseurl+'admin/list_template',$scope.auth_config).success(function(response) {
    $scope.load = false;
    $scope.form.id = response.on_use.id_template;
    $scope.data = response.template;
    if (typeof response.on_use.custom_style == 'string') {
      $scope.part = JSON.parse(response.on_use.custom_style);
      angular.forEach($scope.part,function(value,key) {        
        $scope.set_gradient(key,$scope.part[key].color);
      });
    }
    
  
  }).error(function(xhr){
    console.log(xhr);
    toaster.pop('error','something')
  });  


  $scope.change = function(change) {
    $scope.load = true;
    if(change == 'template'){
      $scope.default_color();
    }
    var data = {
      id : $scope.form.id,
      color : JSON.stringify($scope.part),
      navigasi : $scope.part.sub1.color_select,
      full_color : $scope.part,
      type_change : change 
    }
    
    $http.post(baseurl+'admin/upgrade_template',data,$scope.auth_config).success(function() {
      $scope.load = false;
      toaster.pop('success','Berhasi','Mengganti template')
    }).error(function(){
      $scope.load = false;
      toaster.pop('error','something wrong from server , try to submit change template');
    });
  }

}]);   

app.controller('HiddenTools', ['$scope','$http', 'toaster', function($scope,$http, toaster) {
  $scope.load_sign();
  
  $scope.load= false;
  $scope.download_keyword = function (){
  $scope.load = true;
    $http.get(baseurl+'admin/upgrade_tag_blog',$scope.auth_config).success(function(responses){
      if(responses.success){
        $scope.load = false;
        toaster.pop('success','Pembaruan Tag','Tag Berhasil Di Perbarui');
      }
    }).error(function(error){
      toaster.pop('error','Pembaruan Tag','Tag Gagal Di Perbarui')
      $scope.load= false;
      console.log(error)
    })
  }

  $scope.load_A= false;
  $scope.updagrade_admin = function (){
  $scope.load_A= true;
    $http.get(baseurl+'admin/upgrade_admin',$scope.auth_config).success(function(responses){
      if(responses.success){
        $scope.load_A= false;
        toaster.pop('success','Pembaruan admin','Admin Berhasil Di Perbarui, Refresh Halaman Admin')
      }
    }).error(function(error){
      toaster.pop('error','Pembaruan Admin','Admin Gagal Di Perbarui')
      $scope.load_A = false;
      console.log(error)
    })
  }

}]);   

app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', 'items', function($scope, $modalInstance, items) {
  $scope.items = items;
  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]); 

app.controller('Hapus', ['$scope', '$modalInstance',  function($scope, $modalInstance) {

  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]); 


app.controller('review', ['$scope', '$modalInstance', 'items','$http', function($scope, $modalInstance, items,$http) {
  $scope.items = items;

  $scope.approve = function(id){
    $http.get(baseurl+'admin/review/approve/'+id,$scope.auth_config).success(function(){
      
      $modalInstance.dismiss('cancel');      
    }).error(function(){       
      $modalInstance.dismiss();
    })
  }
  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);  
