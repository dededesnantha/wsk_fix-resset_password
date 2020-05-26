'use strict';

app.controller('KategoriGaleri', ['$scope','$http','$state','$location','toaster', function($scope,$http,$state,$location,toaster) {        
    $scope.load_sign();

    $scope.files = [];  
    $scope.save = function() { 
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin'); 
      $scope.form.image = $scope.files[0];
      $http({
        method  : 'POST',
        url     : baseurl+'admin/do/upload/gambar',    
        transformRequest: function (data) {
            var formData = new FormData();
            formData.append("file", $scope.form.image);            
            return formData;  
        },  
        data : $scope.form,
        headers:$scope.auth_config_photo
      }).success(function(data){          
          if (data.status == 200) {
            $scope.form.gambar = data.data;
          }else{
            $scope.form.gambar = '';
          }
          $http.post(baseurl+'admin/galeri_kategori', $scope.form,$scope.auth_config)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Membuat Kategori');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/galeri/kategori');
          }, function errorCallback(response) {                    
            toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          });           
      }).error(function(xrs){
          console.log(xrs);
          toaster.pop('warning', 'Gagal','Ulang Pengiriman Data!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });
    }

    $scope.uploadedFile = function(element) {
      $scope.currentFile = element.files[0];
      var reader = new FileReader();

      reader.onload = function(event) {
        $scope.image_source = event.target.result
        $scope.$apply(function($scope) {
          $scope.files = element.files;
        });
      }
      reader.readAsDataURL(element.files[0]);
    }  

  
}]);

app.controller('KategoriGaleriRubah', ['$scope','$http','$state','$location','$stateParams','toaster', function($scope,$http,$state,$location,$stateParams,toaster) {    
  $scope.load_sign();

    $scope.form ={};
    $scope.files = [];

    $http.get(baseurl+'admin/galeri_kategori/'+$stateParams.id,$scope.auth_config).success(function(data) {
      $scope.image_source = baseurl+'gambar/400x250/'+data.gambar; 
      $scope.row=data;
      if (data.status == 1) {
        $scope.row.status = true ;
      }else{$scope.row.status = false; }  
    }); 
       
    $scope.save = function() {  
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');
      $scope.row.image = $scope.files[0];
      $http({
        method  : 'POST',
        url     : baseurl+'admin/do/upload/gambar',    
        transformRequest: function (data) {
            var formData = new FormData();
            formData.append("file", $scope.row.image);            
            return formData;  
        },  
        data : $scope.form,
        headers:$scope.auth_config_photo
      }).success(function(data){          
        if (data.status == 200) {
          $scope.form.gambar = data.data;
        }else{
          $scope.form.gambar = '';
        }      
        $http.put(baseurl+'admin/galeri_kategori_update/'+$stateParams.id, $scope.row,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Kategori');            
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/galeri/kategori');
        }, function errorCallback(response) {                    
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

        });      
      }).error(function(xrs){
          console.log(xrs);
          toaster.pop('warning', 'Gagal','Ulang Pengiriman Data!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });
    }
    $scope.uploadedFile = function(element) {
      $scope.currentFile = element.files[0];
      var reader = new FileReader();

      reader.onload = function(event) {
        $scope.image_source = event.target.result
        $scope.$apply(function($scope) {
          $scope.files = element.files;
        });
      }
      reader.readAsDataURL(element.files[0]);
    }
  
}]);

  // sosialmedia controller
app.controller('SemuaKategoriGaleri', ['$scope','$http','$state','$location','$modal','toaster','$timeout', function($scope,$http,$state,$location,$modal,toaster,$timeout) {    
  $scope.load_sign();

  $scope.url_link = baseurl+'gallery/';
  $scope.gambar = baseurl+'gambar/100x60/';  
  $http.get(baseurl+'admin/all_galeri_kategori',$scope.auth_config).success(function(data) {
    $scope.kategori=data;
    $timeout(function(){
      $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized').trigger('footable_expand_all');        
    }, 100);    
  });

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
      $http.delete(baseurl+'admin/galeri_kategori/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Kategori');
        $http.get(baseurl+'admin/all_galeri_kategori',$scope.auth_config).success(function(data) {
          $scope.kategori=data;
          $timeout(function(){
            $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized').trigger('footable_expand_all');        
          }, 100);  
        });        
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
      
    });
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


app.controller('Semua_Galeri', ['$scope', 'FileUploader','toaster','$http','$state','$timeout','$modal','$localStorage', function($scope, FileUploader,toaster,$http,$state,$timeout,$modal,$localStorage) {
  $scope.load_sign();

  $http.get(baseurl+'admin/all_galeri_kategori',$scope.auth_config).success(function(data) {    
    $scope.kategori=data;              
    $timeout(function(){
      $scope.form = {
        kategori:data[0].id
      }
    }, 100); 
  });

  var uploader = $scope.uploader = new FileUploader({
      url: baseurl+'admin/do/upload/galery',
      headers : $scope.auth_config_multi,
      autoUpload : true,
      removeAfterUpload :true
  });
  // FILTERS        
  uploader.filters.push({
      name: 'syncFilter',
      fn: function(item /*{File|FileLikeObject}*/, options) {            
          return this.queue.length < 20;
      }
  });
    

  $scope.gambar = baseurl+'galeri/150x100/'; 
  $scope.field = [{    
    name:'All',
    target:'all'
  },{
    name:'Judul',
    target:'galeri.judul'
  },{    
    name:'Kategori',
    target:'galeri_kategori.judul'
  }
  ];
  $scope.search={
    much : 10,
    field : 'galeri.judul',    
    order : 'desc',
    search :''
  };
  $scope.default={
    much : 10,
    field : 'galeri.judul',    
    order : 'desc',
    search :''
  };

  $scope.currentPage = 1;
  $scope.totalItems ={};
  var search = '';
  $scope.load = true;  

  if ( angular.isDefined($localStorage.galeri_search) ) {
    $scope.search = $localStorage.galeri_search;
  }
  $scope.$watch('search', function(){
    $localStorage.galeri_search = $scope.search;
  }, true);
  $scope.$watch('currentPage', function(){
    $localStorage.blog_current = $scope.currentPage;
  }, true);

  $scope.remove = function(){
    $scope.search={
      much : 10,
      field : 'galeri.judul',    
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
    if ($scope.search.search == ' ') {
      search = 'all';
    }else{
      search = $scope.search.search;
    }
    if ( angular.isDefined($localStorage.blog_current) ) {
      $scope.currentPage = $localStorage.blog_current;
    }
    
    $scope.search.cari = search;
    $http.post(baseurl+'admin/galeri/all?page='+$scope.currentPage,$scope.search,$scope.auth_config).success(function(data) {
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
  // CALLBACKS
 
  uploader.onCompleteItem = function(fileItem, response, status, headers) {        
    if (response.status == 200) {
      $http.post(baseurl+'admin/galeri_baru', {text:response.data,kategori:$scope.form.kategori},$scope.auth_config)
      .then(function successCallback(response) {          
      }, function errorCallback(response) {                    
        toaster.pop('warning', 'Gagal','Masukan Kategori!');
      });
    }
  };
  uploader.onCompleteAll = function() {
      toaster.pop('success', 'Berhasil','Mengupload Semua Galeri');
      uploader.clearQueue();      
      $scope.load_data();      
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
      $http.delete(baseurl+'admin/galeri_hapus/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Galeri');                
          $scope.load_data('paging');        
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
      
    });
  };

  $scope.del = [];
  $scope.select_all = false;
  $scope.$watch('select_all', function(){      
      console.log($scope.del);
      if($scope.select_all){
        $scope.dataset.forEach(element => {      
          $scope.del[element['id']] = true
        });
      }else{        
        if(Array.isArray($scope.dataset)){
          $scope.dataset.forEach(element => {      
            $scope.del[element['id']] = false
          });
        }
      }
    
  }, true);
  
  $scope.do_delete = false;
  $scope.do_delete_text = function(){
    if($scope.do_delete == true){
      return 'Batal'
    }else{
      return 'Hapus'
    }
  }
  $scope.set_to_delete = function(){
    if($scope.do_delete == true){
      $scope.do_delete=false
      $scope.select_all = false;
    }else{
      $scope.do_delete=true;
    }
  }

  $scope.delete_multi = function () {
    var modalInstance = $modal.open({
      templateUrl: 'myModalContent.html',
      controller: 'Hapus'
    });
    modalInstance.result.then(function () {      
      $http.post(baseurl+'admin/galeri/delete',$scope.del,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Galery');
        $scope.load_data('paging');
        $scope.select_all = false;      
        $scope.do_delete = false;           
      }, function errorCallback(response) {
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
      
    });
  };
  
}]);

app.controller('GaleriRubah', ['$scope','$http','$state','$location','$stateParams','toaster', function($scope,$http,$state,$location,$stateParams,toaster) {    
    $scope.load_sign();
    
    $http.get(baseurl+'admin/all_galeri_kategori',$scope.auth_config).success(function(data) {
      $scope.kategori=data;          
    }); 
        
    $http.get(baseurl+'admin/galeri/'+$stateParams.id,$scope.auth_config).success(function(data) {
      $scope.row=data;      
    });
    
    $scope.save = function() {  
                   
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.put(baseurl+'admin/galeri/'+$stateParams.id, $scope.row,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Galeri');            
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        console.log($scope.row);
        $location.path('/app/galeri/semua_galeri');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });          
      
    }

  
}]);