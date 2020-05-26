'use strict';

/* Controllers */

app.controller('SemuaAjaran', ['$scope','$http','$modal','toaster','$timeout','$localStorage','$stateParams','$window', function($scope,$http,$modal,toaster,$timeout,$localStorage,$stateParams,window) {    
  $scope.load_sign();
  
  $scope.url_link = baseurl+'ajaran/';
  
  $http.get(baseurl+'admin/all_ajaran',$scope.auth_config).success(function(data) {
    $scope.dataset=data;
    $timeout(function(){
      $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized').trigger('footable_expand_all');        
    }, 100);    
  });
  
}]);


app.controller('AjaranBaru', ['$scope','$http','$location','toaster','$modal', function($scope,$http,$location,toaster,$modal) {
    $scope.load_sign();

    $scope.tinymceOptions = {
      plugins : 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code insertdatetime media table paste',
      height: 300,
      menubar: false,
      relative_urls : false,
      remove_script_host : false,
      toolbar_items_size: 'small',
      toolbar: "formatselect | bold italic underline strikethrough blockquote | table alignleft aligncenter alignright alignjustify | outdent indent bullist numlist | link unlink anchor | get-image media | code",  
    };
  
    $scope.form = {};
    $scope.save = function() {
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.post(baseurl+'admin/ajaran_baru', $scope.form,$scope.auth_config)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Membuat Ajaran Baru');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/tahun/semua_tahun');
          }, function errorCallback(response) {                    
            toaster.pop('error', 'Gagal','Harap Periksa Data Anda!');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

          });
    }
  
}]);

app.controller('AjaranUpdate', ['$scope','$http','$location','$stateParams','toaster','$state','$modal', function($scope,$http,$location,$stateParams,toaster,$state,$modal) {      
  
    //get data ajaran
  $http.get(baseurl+'admin/ajaran_rubah/'+$stateParams.id,$scope.auth_config).success(function(data) {      
    $scope.form=data;
    if (data.status == 1) {
          $scope.form.status = true ;
        }else{$scope.form.status = false; }
  });  
  $scope.save = function() {
    $('#submit').addClass('disabled').removeClass('btn-addon');
    $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                       
    $http.put(baseurl+'admin/ajaran_update/'+$stateParams.id, $scope.form,$scope.auth_config)
    .then(function successCallback(response) {
      toaster.pop('success', 'Berhasil','Merubah Ajaran');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      $location.path('/app/tahun/semua_tahun');  
    }, function errorCallback(response) {
      toaster.pop('error', 'Gagal','Harap Periksa Data Anda!');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
    });                
  }

}]);

app.controller('SemuaMahasiswa', ['$scope','$http','$modal','toaster','$timeout','$localStorage','$stateParams','$window', function($scope,$http,$modal,toaster,$timeout,$localStorage,$stateParams,window) {    
  $scope.load_sign();

  $scope.field = [{    
    name:'All',
    target:'all'
  },{
    name:'No Registrasi',
    target:'no_registrasi'
  }
  ];

   $scope.form={
    much : 10,
    field : 'no_registrasi',    
    order : 'desc',
    search :''
  };
  $scope.default={
    much : 10,
    field : 'no_registrasi',    
    order : 'desc',
    search :''
  };
  $scope.currentPage = 1;
  $scope.totalItems ={};
  var search = '';
  $scope.load = true;  
  
   if ( angular.isDefined($localStorage.blog_wsk) ) {
    $scope.form = $localStorage.blog_search;
  }
  $scope.$watch('form', function(){
    $localStorage.wsk_search = $scope.form;
  }, true);
  $scope.$watch('currentPage', function(){
    $localStorage.wsk_current = $scope.currentPage;
  }, true);

  $scope.remove = function(){
    $scope.form={
      much : 10,
      field : 'no_registrasi',    
      order : 'desc',
      search :''
    };
    $scope.load_data();
  }

  $scope.load_data = function(paging = '') {
    if (paging == '') {
      $scope.currentPage = 1;
    }
    $scope.dataset = {};
    $scope.load = true;
    if ($scope.form.search == ' ') {
      search = 'all';
    }else{
      search = $scope.form.search;
    }

    if ( angular.isDefined($localStorage.wsk_current) ) {
      $scope.currentPage = $localStorage.wsk_current;
    }
    
    // get ajaran
      $http.get(baseurl+'admin/tahun/'+$stateParams.id,$scope.auth_config).success(function(data) {
      $scope.tahun=data;
      });
    
    $scope.form.cari = search;
    $scope.form.id = $stateParams.id;
    $http.post(baseurl+'admin/all_mahasiswa?page='+$scope.currentPage,$scope.form,$scope.auth_config,).success(function(data) {
      $scope.load = false;
      $scope.dataset=data.data;
      $scope.totalItems = data.total;
      $scope.currentPage = data.current_page;
      $timeout(function(){
        $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized').trigger('footable_expand_all'); 
      }, 100);
      $scope.del = [];
      $scope.select_all = false;      
      $scope.dataset.forEach(element => {      
        $scope.del[element['id']] = false
      });
    }); 
  }

  $scope.load_data();


   $scope.r_open = function (id) {
      $http.get(baseurl+'admin/edit_mahasiswa/'+id,$scope.auth_config).success(function(data) {
        $scope.d_item=data;

        var modalInstance = $modal.open({
          templateUrl: 'update_data',
          controller: 'UpdateMahasiswa',      
          resolve: {
            items: function () {
              return $scope.d_item;
            }
          }
        });
        modalInstance.result.then(function () {    
          toaster.pop('success','Berhasil Mengubah Status Pembayran')      
          $scope.load_data('paging');
          
        }, function () {
          
        });

      });
   }


  $scope.open_modal = function (id) {
      $http.get(baseurl+'admin/view_mahasiswa/'+id,$scope.auth_config).success(function(data) {
        $scope.r_items=data;

        var modalInstance = $modal.open({
          templateUrl: 'view_data',
          controller: 'DataMahasiswa',      
          resolve: {
            items: function () {
              return $scope.r_items;
            }
          }
        });
      });    
    };

    $scope.delete = function (id) {
    var modalInstance = $modal.open({
      templateUrl: 'myModalContent.html',
      controller: 'Hapus',      
      resolve: {
        items: function () {
          return $scope.items;
        }
      }
    });
    modalInstance.result.then(function () {      
      $http.delete(baseurl+'admin/mahasiswa/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Mahasiswa!');
        $scope.load_data('paging');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!'); 
        $scope.load_data('paging');       
      });   

    }, function () {
      
    });
  };

  // Export EXCEL
  $scope.export_data = function (id) {
    window.location.assign('mahasiswa/sudah/daftar_ulang/export/xlsx/'+id,$scope.auth_config, '_blank');
    };

    $scope.export_datas = function (id) {
    window.location.assign('mahasiswa/belum/daftar_ulang/export/xlsx/'+id,$scope.auth_config, '_blank'); 
    };

}]);

app.controller('DataMahasiswa', ['$scope', '$modalInstance','items','toaster','$http',  function($scope, $modalInstance,items,toaster,$http) {
  $scope.load_sign();
  $scope.items = items;

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };

}]); 

app.controller('UpdateMahasiswa', ['$scope', '$modalInstance','items','toaster','$http',  function($scope, $modalInstance,items,toaster,$http) {
  $scope.items = items;
  
   $scope.mahasiswa_edit = { 
    edit:()=>{      
        $http.put(baseurl+'admin/mahasiswa/update/'+$scope.items.id,$scope.items,$scope.auth_config)
        .success(function(response){
          $modalInstance.close();
        }).error(function(xhr) {        
          toaster.pop('error','Gagal Mengubah')                
        })
    }
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