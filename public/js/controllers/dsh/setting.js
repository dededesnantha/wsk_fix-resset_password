'use strict';

/* Controllers */

  // profile website
app.controller('Navigasi', ['$scope', function($scope) {
  $scope.load_sign();
}]);

app.controller('ProfileWebsite', ['$scope','$http','$location','toaster','$state', function($scope,$http,$location,toaster,$state) {      
  $scope.load_sign();
  
  $scope.load_category = function(){
    $http.get(baseurl+'admin/all_kategori',$scope.auth_config).success(function(data) {
      $scope.kategori=data;    
    }); 
    $http.get(baseurl+'admin/blog/shortcut/category',$scope.auth_config).success(function(data){
      $scope.keyword = data;
    }).error(function(){
      console.log('error');
    });
  }
  $scope.load_category ();

  $scope.files = [];
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

  $http.get(baseurl+'admin/profile_website',$scope.auth_config).success(function(data) {
    $scope.gambar = baseurl+'image/';
    $scope.form=data;
  });
  $scope.save = function() {
    $http.put(baseurl+'admin/profile_website', $scope.form,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Profile Website Diperbarui');
      }, function errorCallback(response) {
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
      });
  }

  $scope.save_logo = function() {  
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
      headers: $scope.auth_config_photo
    }).success(function(data){          
        $scope.form.gambar = data.data;
        $('#submit').addClass('disabled').removeClass('btn-addon');
        $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
        
        $http.put(baseurl+'admin/profile_website_logo', $scope.form,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Logo');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/profile_website');
        }, function errorCallback(response) {                    
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

        });          
    });
  }
  $scope.save_gambar = function() {  
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
      headers: $scope.auth_config_photo
    }).success(function(data){          
        $scope.form.gambar = data.data;
        $('#submit').addClass('disabled').removeClass('btn-addon');
        $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');        
        $http.put(baseurl+'admin/profile_website_gambar', $scope.form,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Logo');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/profile_website');
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        });
    });
  }

  //sisipakn tag
  $scope.loading_tag = false;
  $scope.data_tag = {};
  $scope.insertion = function(){
    $scope.loading_tag = true;
    $http.post(baseurl+'admin/interject/tag',$scope.data_tag,$scope.auth_config).success(function(response){      
      if (response.status == 200) {
          toaster.pop('success', 'Berhasil',response.message);                      
          $scope.loading_tag = false;
      }else{
          toaster.pop('danger', 'Peringatan',response.message);
          $scope.loading_tag = false;
      }

    }).error(function(){
      $scope.loading_tag = false;
    })
  }

  
}]);

 // sosialmedia controller
app.controller('SosialMedia', ['$scope','$http','$location','toaster','$state', function($scope,$http,$location,toaster,$state) {    
  $scope.load_sign();

  $scope.path = baseurl+'image/sm/';
  $scope.files = [];
  $scope.radioModel = 'sm/blog.jpg';

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
      headers: $scope.auth_config_photo
    }).success(function(data){          
        $scope.form.gambar = data.data;        
        
        $http.post(baseurl+'admin/sosial_media', $scope.form,$scope.auth_config)
        .then(function successCallback(response) {
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          toaster.pop('success', 'Berhasil','Menambah Sosial Media');
          $location.path('/app/setting/sosial_media');  
        }, function errorCallback(response) {
          toaster.pop('warning', 'Gagal','Masukan Data Dengan Lengkap!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        });            
    });

  }

}]);

app.controller('SemuaSosialMedia', ['$scope','$http','$location','$modal','toaster','$timeout','$state', function($scope,$http,$location,$modal,toaster,$timeout,$state) {    
  $scope.load_sign();

  $scope.gambar = baseurl+'image/';  
  $http.get(baseurl+'admin/sosial_media',$scope.auth_config).success(function(data) {
    $scope.dataset=data;
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
      $http.delete(baseurl+'admin/sosial_media/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Sosial Media');
        $http.get(baseurl+'admin/sosial_media',$scope.auth_config).success(function(data) {
          $scope.dataset=data;
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



app.controller('SosialMediaRubah', ['$scope','$http','$location','$stateParams','toaster','$state', function($scope,$http,$location,$stateParams,toaster,$state) {    
  $scope.load_sign();

  $scope.path = baseurl+'image/sm/';
  $scope.files = [];
  $scope.radioModel = 'sm/blog.jpg';

  $http.get(baseurl+'admin/sosial_media_rubah/'+$stateParams.id,$scope.auth_config).success(function(data) {      
    $scope.form=data;
    $scope.form.ikon = data.gambar;  
    if (data.gambar.split('/')[0] != 'sm'){      
      $scope.image_source = baseurl+'image/'+data.gambar;
    }

  });  

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
      headers: $scope.auth_config_photo
    }).success(function(data){          
        $scope.form.gambar = data.data;        
        
        $http.put(baseurl+'admin/sosial_media_ikon/'+$stateParams.id, $scope.form,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Sosial Media');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/sosial_media');  
        }, function errorCallback(response) {
          toaster.pop('warning', 'Gagal','Pilih Ikon Terlebih Dahulu!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        });            
    });
  }

}]);


 // Kontak controller
app.controller('Kontak', ['$scope','$http','$location','toaster','$state', function($scope,$http,$location,toaster,$state) {    
  $scope.load_sign();

  $scope.path = baseurl+'image/sm/';
  
  $scope.save = function() {  
    $('#submit').addClass('disabled').removeClass('btn-addon');
    $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');

    $http.post(baseurl+'admin/kontak', $scope.form,$scope.auth_config)
    .then(function successCallback(response) {
      toaster.pop('success', 'Berhasil','Menambah Kontak');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      $location.path('/app/setting/kontak');  
    }, function errorCallback(response) {
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
    });                
  }

}]);

app.controller('SemuaKontak', ['$scope','$http','$location','$modal','toaster','$timeout','$state', function($scope,$http,$location,$modal,toaster,$timeout,$state) {    
  $scope.load_sign();

  $scope.gambar = baseurl+'image/';  
  $http.get(baseurl+'admin/kontak',$scope.auth_config).success(function(data) {
    $scope.dataset=data;
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
      $http.delete(baseurl+'admin/kontak/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Kontak');
        $http.get(baseurl+'admin/kontak',$scope.auth_config).success(function(data) {
          $scope.dataset=data;
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

app.controller('KontakRubah', ['$scope','$http','$location','$stateParams','toaster','$state', function($scope,$http,$location,$stateParams,toaster,$state) {   
  $scope.load_sign();

  $scope.path = baseurl+'image/sm/';
  $scope.files = [];  
  $http.get(baseurl+'admin/kontak_rubah/'+$stateParams.id,$scope.auth_config).success(function(data) {      
    $scope.form=data;
    $scope.image_source = baseurl+'image/'+data.gambar; 
  });  
  $scope.save = function() {  
    $('#submit').addClass('disabled').removeClass('btn-addon');
    $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                       
    $http.put(baseurl+'admin/kontak_update/'+$stateParams.id, $scope.form,$scope.auth_config)
    .then(function successCallback(response) {
      toaster.pop('success', 'Berhasil','Merubah Kontak');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      $location.path('/app/setting/kontak');  
    }, function errorCallback(response) {
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
    });                
  }

}]);


 // Administrator controller
app.controller('SemuaAdministrator', ['$scope','$http','$location','$modal','toaster','$timeout','$state', function($scope,$http,$location,$modal,toaster,$timeout,$state) {
  $scope.load_sign();

  $http.get(baseurl+'admin/administrator',$scope.auth_config).success(function(data) {
    $scope.dataset=data;
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
      $http.delete(baseurl+'admin/administrator/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Admin');
        $http.get(baseurl+'admin/administrator',$scope.auth_config).success(function(data) {
          $scope.dataset=data;
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

app.controller('Administrator', ['$scope','$http','$location','toaster','$state', function($scope,$http,$location,toaster,$state) {  
  $scope.load_sign();

  $scope.save = function() {
    $('#submit').addClass('disabled').removeClass('btn-addon');
    $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                       
    $http.post(baseurl+'admin/administrator', $scope.form,$scope.auth_config)
    .then(function successCallback(response) {
      toaster.pop('success', 'Berhasil','Menambah Admin');
      $location.path('/app/setting/admin');  
    }, function errorCallback(response) {
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
    });                
  }
}]);

app.controller('AdministratorRubah', ['$scope','$http','$location','$stateParams','toaster','$state', function($scope,$http,$location,$stateParams,toaster,$state) {    
    $scope.load_sign();

    $http.get(baseurl+'admin/administrator/'+$stateParams.id,$scope.auth_config).success(function(data) {      
      $scope.form=data;      
    });     
    $scope.save = function() {                  
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                                   
      $http.put(baseurl+'admin/administrator/'+$stateParams.id, $scope.form,$scope.auth_config)
      .then(function successCallback(response) {        
        if (response.data.success == true) {
          toaster.pop('success', 'Berhasil','Merubah Admin');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/admin');
        }else{
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          toaster.pop('warning', 'Warning','Password Tidak Sesuai');
        }

      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });        
    }
}]);
 
 // tag controller
app.controller('TagRubah', ['$scope','$http','$location','$stateParams','toaster','$state', function($scope,$http,$location,$stateParams,toaster,$state) {    
    $scope.load_sign();
  
    $http.get(baseurl+'admin/tag/'+$stateParams.id,$scope.auth_config).success(function(data) {
      $scope.row=data;      
    });     
    
    $scope.save = function() {  
                   
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.put(baseurl+'admin/tag_update/'+$stateParams.id, $scope.row,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Tag');            
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/setting/tag');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });          
      
    }
  
}]);

app.controller('SemuaTag', ['$scope','$http','$location','$modal','toaster','$timeout','$state', function($scope,$http,$location,$modal,toaster,$timeout,$state) {    
  $scope.load_sign();

  $scope.field = [{    
    name:'All',
    target:'all'
  },{
    name:'Judul',
    target:'judul'
  }];
  $scope.form={
    much : 10,
    field : 'judul',    
    order : 'desc',
    search :''  
  };

  $scope.currentPage = 1;
  $scope.totalItems ={};
  var search = '';
  $scope.load = true;  

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
    $scope.form.cari = search;
    $http.post(baseurl+'admin/all_tag?page='+$scope.currentPage,$scope.form,$scope.auth_config).success(function(data) {
      $scope.load = false;
      $scope.dataset=data.data;
      $scope.totalItems = data.total;
      $scope.currentPage = data.current_page;
      $timeout(function(){
        $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized').trigger('footable_expand_all');                
      }, 100); 
    }); 
  }
  
  $scope.load_data();
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
      $http.delete(baseurl+'admin/tag/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Tag');
        $scope.load_data('paging');
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


// Home Settin controller
app.controller('HomeSetting', ['$scope','$http','toaster','$modal','$state', function($scope,$http,toaster,$modal,$state) {
  $scope.load_sign();

  $scope.status = {};
  $scope.oneAtATime = true; 
  $scope.oneAtATimes = false; 
  $scope.addspecial = true; 
  $scope.setting=[];
  $scope.page_item = {};

  $http.get(baseurl+'admin/home_setting',$scope.auth_config).success(function(data) {      
    $scope.setting=data;         
    $scope.accordion = false;    
    if ($scope.setting.status == 1) {
      $scope.setting.status = true ;
    }else{$scope.setting.status = false; }

    if ($scope.setting.custom == 1) {
      $scope.setting.custom = true;
    }else{$scope.setting.custom = false;}
  });  
    
  $http.get(baseurl+'admin/all_kategori_position',$scope.auth_config).success(function(data) {
    $scope.pkategori=data;         
    if ($scope.pkategori.status == 1) {
      $scope.pkategori.status = true ;
    }else{$scope.pkategori.status = false; }
  });

  $scope.up = function(id){    
    $http.get(baseurl+'admin/kategori/up/'+id,$scope.auth_config).success(function(){      
      $http.get(baseurl+'admin/all_kategori_position',$scope.auth_config).success(function(data) {
        $scope.pkategori=data;         
        if ($scope.pkategori.status == 1) {
          $scope.pkategori.status = true ;
        }else{$scope.pkategori.status = false; }
      });
    })
  }
  $scope.down = function(id){    
    $http.get(baseurl+'admin/kategori/down/'+id,$scope.auth_config).success(function(){      
      $http.get(baseurl+'admin/all_kategori_position',$scope.auth_config).success(function(data) {
        $scope.pkategori=data;         
        if ($scope.pkategori.status == 1) {
          $scope.pkategori.status = true ;
        }else{$scope.pkategori.status = false; }
      });
    })
  }
  $scope.kategori_klik = function(status,id) {                  
    $http.put(baseurl+'admin/kategori_setting/'+id, {text :status},$scope.auth_config)
    .then(function successCallback(response) {            
        toaster.pop('success', 'Berhasil','Perubahan Disimpan');
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });        
  }
  $scope.klik_active = function(status,id) {                  
    $http.put(baseurl+'admin/setting_active/'+id, {text :status},$scope.auth_config)
    .then(function successCallback(response) {            
        toaster.pop('success', 'Berhasil','Perubahan Disimpan');
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });        
  }

  $scope.setting_up = function (id) {    
    $http.get(baseurl+'admin/setting_up/'+id,$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Posisi Pindah');        
        $http.get(baseurl+'admin/home_setting',$scope.auth_config).success(function(data) {      
          $scope.setting=data;         
          
          if ($scope.setting.status == 1) {
            $scope.setting.status = true ;
          }else{$scope.setting.status = false; }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.setting_down = function (id) {    
    $http.get(baseurl+'admin/setting_down/'+id,$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Posisi Pindah');        
        $http.get(baseurl+'admin/home_setting',$scope.auth_config).success(function(data) {      
          $scope.setting=data;         
          
          if ($scope.setting.status == 1) {
            $scope.setting.status = true ;
          }else{$scope.setting.status = false; }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.save = function (status,id) {    
    $http.put(baseurl+'admin/home_setting/'+id,status,$scope.auth_config)
    .then(function successCallback(response) {        
        toaster.pop('success', 'Berhasil','Dirubah');                
        $http.get(baseurl+'admin/setting_special',$scope.auth_config).success(function(data) {      
          $scope.special=data;    
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }

}]); 
//special offer
app.controller('SpecialOffer', ['$scope','$http','toaster','$modal','$state', function($scope,$http,toaster,$modal,$state) {
  $scope.load_sign();

  $scope.oneAtATime = true; 
  $scope.addspecial = true; 
  $scope.setting=[];  
  $scope.pages =[];  
  $scope.pro =[];  
  $scope.load_data = function(){
    $http.get(baseurl+'admin/setting_special',$scope.auth_config).success(function(data) {
      $scope.special=data;

      $scope.del = [];
      $scope.select_all = false;      
      $scope.special.forEach(element => {      
        $scope.del[element['id']] = false
      });
    });
  }
  
  $scope.load_data();
  $scope.del = [];
  $scope.select_all = false;
  $scope.$watch('select_all', function(){      
      console.log($scope.del);
      if($scope.select_all){
        $scope.special.forEach(element => {      
          $scope.del[element['id']] = true
        });
      }else{        
        if(Array.isArray($scope.special)){
          $scope.special.forEach(element => {      
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
      $http.post(baseurl+'admin/special_hapus/multi',$scope.del,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Special Produk');
        $scope.load_data();
        $scope.select_all = false;      
        $scope.do_delete = false;           
      }, function errorCallback(response) {                   
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
      
    });
  };

  $http.get(baseurl+'admin/all_kategori_position',$scope.auth_config).success(function(data) {
    $scope.pkategori=data;
    if ($scope.pkategori.status == 1) {
      $scope.pkategori.status = true ;
    }else{$scope.pkategori.status = false; }
  });

  $http.get(baseurl+'admin/get_kategori_produk',$scope.auth_config).success(function(data) {      
    $scope.list_kategori=data.product;
  });

  $http.get(baseurl+'admin/all_page',$scope.auth_config).success(function(data) {      
    $scope.page=data;  
  });

  $scope.up = function(id){
    
    $http.get(baseurl+'admin/special_offer/up/'+id,$scope.auth_config).success(function(){    
      $http.get(baseurl+'admin/setting_special',$scope.auth_config).success(function(data) {      
        $scope.special=data;    
      });
    })
  }
  $scope.down = function(id){    
    $http.get(baseurl+'admin/special_offer/down/'+id,$scope.auth_config).success(function(){    
      $http.get(baseurl+'admin/setting_special',$scope.auth_config).success(function(data) {      
        $scope.special=data;    
      });
    })
  }

  $scope.klik_page = function () { 
    $http.post(baseurl+'admin/spesial_produk_page', {text : $scope.pages.id},$scope.auth_config)
    .then(function successCallback(response) {        
        $scope.pages.id='';
        if (response.data.success == true) {
          toaster.pop('success', 'Berhasil','Page Spesial Di Tambah');
          $scope.load_data();
        }
        if (response.data.warning == true) {
          toaster.pop('warning', 'Perhatian','Page Yang Sudah Di Tambah Tidak Akan Di Masukan');
        }     
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Data Anda!');      
    });
  }
  $scope.spesial = function (id) {    
    $http.post(baseurl+'admin/spesial_produk',{text: $scope.pro.text[id]},$scope.auth_config)
    .then(function successCallback(response) {
        $scope.pro.text[id]=false;
        $scope.load_data();                     
        toaster.pop('success', 'Berhasil','Paket Tour Spesial Di Tambah');
        if (response.data.warning == true) {
          toaster.pop('warning', 'Perhatian','Paket Tour Yang Sudah Di Tambah Tidak Akan Di Masukan');
        }
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
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
      $http.delete(baseurl+'admin/special_hapus/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Special Produk');        
        $scope.load_data();        
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Gagal Menghapus!');        
      });   

    }, function () {
        
    });
  }; 

}]); 

//slider
app.controller('FileUploadCtrl', ['$scope', 'FileUploader','toaster','$http','$timeout','$modal','$state', function($scope, FileUploader,toaster,$http,$timeout,$modal,$state) {        
  $scope.load_sign();

  $scope.path = baseurl+'galeri/150x100/'; 
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

  $scope.load_data = function(){
    $http.get(baseurl+'admin/slider',$scope.auth_config).success(function(data) {
      $scope.dataset=data;
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

  $scope.up = function(id){    
    $http.get(baseurl+'admin/slider/up/'+id,$scope.auth_config).success(function(){      
      $scope.load_data();
    })
  }
  $scope.down = function(id){    
    $http.get(baseurl+'admin/slider/down/'+id,$scope.auth_config).success(function(){      
      $scope.load_data();
    })
  }

  // CALLBACKS

  uploader.onCompleteItem = function(fileItem, response, status, headers) {        
      $http.post(baseurl+'admin/slider_baru', {text:response.data},$scope.auth_config)
      .then(function successCallback(response) {          
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
      });       
  };
  uploader.onCompleteAll = function() {
      toaster.pop('success', 'Berhasil','Mengupload Semua Slider');
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
      $http.delete(baseurl+'admin/slider_hapus/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Slider');        
        $scope.load_data();
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
      $http.post(baseurl+'admin/slider/delete',$scope.del,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Slider');
        $scope.load_data();
        $scope.select_all = false;      
        $scope.do_delete = false;           
      }, function errorCallback(response) {                   
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
      
    });
  };

  
}]);

app.controller('SliderRubah', ['$scope','$http','$location','$stateParams','toaster','$state', function($scope,$http,$location,$stateParams,toaster,$state) {    
    $scope.load_sign();

    $http.get(baseurl+'admin/slider/'+$stateParams.id,$scope.auth_config).success(function(data) {
      $scope.row=data;      
    });     
    
    $scope.save = function() {                  
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.put(baseurl+'admin/slider/'+$stateParams.id, $scope.row,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Slider');            
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        console.log($scope.row);
        $location.path('/app/setting/semua_slider');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });          
      
    }  
}]);

// Menu controller
app.controller('Menu', ['$scope','$http','toaster','$modal','$state','$timeout', function($scope,$http,toaster,$modal,$state,$timeout) {
  $scope.load_sign();

  $scope.oneAtATime = true;
  $scope.form =[];
  $scope.pages =[];
  $scope.kategoris =[];
  $scope.custom =[]
  $scope.home =[];
  $scope.blogs =[];
  $scope.kontaks =[];
  $scope.bookings =[];  
  $scope.gallerys =[];  
  $scope.reviews =[];  
  
  $scope.home.judul = 'home';
  $scope.pages.judul = 'page';
  $scope.kategoris.judul = 'kategori';  
  $scope.blogs.judul = 'blog';
  $scope.kontaks.judul = 'contact';
  $scope.bookings.judul = 'booking';
  $scope.gallerys.judul = 'gallery';
  $scope.reviews.judul = 'review';

  $scope.home.link = '';
  $scope.blogs.link = 'blog/';
  $scope.kontaks.link = 'contact.html';
  $scope.bookings.link = 'booking.html';
  $scope.gallerys.link = 'gallery.html';
  $scope.reviews.link = 'review.html';

  $http.get(baseurl+'admin/all_page',$scope.auth_config).success(function(data) {      
    $scope.page=data;  
  });
  $http.get(baseurl+'admin/all_kategori',$scope.auth_config).success(function(data) {      
    $scope.pkategori=data;  
  });

  $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {          
    $scope.menu=data;
    $scope.accordion = false;
  });

  $scope.gambar = baseurl+'gambar/100x60/';  
  $scope.field = [{    
    name:'All',
    target:'all'
  },{
    name:'Judul',
    target:'product.judul'
  },{    
    name:'Kategori',
    target:'kategori.judul'
  },{
    name:'Status',
    target:'product.status'
  },{
    name:'View',
    target:'product.view'
  }
  ];
  $scope.form={
    much : 10,
    field : 'product.judul',    
    order : 'desc',
    search :''
  };

  $scope.currentPage = 1;
  $scope.totalItems ={};
  var search = '';
  $scope.load = false;  
  $scope.dataset = [];

  $scope.load_data = function(currentPage,paging = '') {
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
    $scope.form.cari = search;
    $http.post(baseurl+'admin/all_produk?page='+currentPage,$scope.form,$scope.auth_config).success(function(data) {
      $scope.load = false;
      $scope.dataset=data.data;
      $scope.totalItems = data.total;
      $scope.currentPage = data.current_page;
      $timeout(function(){
        $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized').trigger('footable_expand_all');                
      }, 100); 
    }); 
  }

  $scope.klik_page = function () {        
    $http.post(baseurl+'admin/menu', {judul : $scope.pages.judul,link : $scope.pages.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.pages.link ='';
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kategori = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kategoris.judul,link : $scope.kategoris.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.kategoris.link ='';
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.products ={};
  $scope.klik_product = function () {    
    $http.post(baseurl+'admin/menu', {judul : 'produk',link : $scope.products.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.products.link ='';
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_custom_link = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.custom.judul,link : $scope.custom.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.custom =[];
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_blog = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.blogs.judul,link : $scope.blogs.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kontak = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kontaks.judul,link : $scope.kontaks.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_booking = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.bookings.judul,link : $scope.bookings.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_gallery = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.gallerys.judul,link : $scope.gallerys.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_review = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.reviews.judul,link : $scope.reviews.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_home = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.home.judul,link : $scope.home.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  ///
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
      $http.delete(baseurl+'admin/menu/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Menu');                
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
        
    });
  };

  $scope.menu_up = function (id) {    
    $http.get(baseurl+'admin/menu_up/'+id,$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Pindah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('warning', 'Gagal','Tidak Datap Dipindahkan!');      
    });
  }
  $scope.menu_down = function (id) {    
    $http.get(baseurl+'admin/menu_down/'+id,$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Pindah');        
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('warning', 'Gagal','Tidak Datap Dipindahkan!');      
    });
  }
  
  $scope.save = function (status,id) {    
    $http.put(baseurl+'admin/menu/'+id,status,$scope.auth_config)
    .then(function successCallback(response) {        
        toaster.pop('success', 'Berhasil','Dirubah');                
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {          
          $scope.menu=data;
          $scope.accordion = false;
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }

}]); 
app.controller('MenuTambahan', ['$scope','$http','toaster','$modal','$state', function($scope,$http,toaster,$modal,$state) {
  $scope.load_sign();

  $scope.oneAtATime = true;
  $scope.form = [];
  $scope.list_kolom = [
    {judul:'Sosial Media',role:1},
    {judul:'Kontak',role:2},
    {judul:'Logo',role:3},
    {judul:'Deskripsi',role:4},    
    {judul:'Semua Kategori',role:5},
    {judul:'Profil Website',role:6},
    {judul:'Special Offer',role:7},
    {judul:'Menu',role:8}
  ];
  $scope.custom =[]
    
  $scope.blog =[];
  $scope.blog.judul = 'blog';
  $scope.blog.link = baseurl+'blog/'; 

  $scope.sitemap =[];
  $scope.sitemap.judul = 'sitemap';
  $scope.sitemap.link = baseurl+'sitemap.xml';

  $scope.galeri =[];
  $scope.galeri.judul = 'galeri';
  $scope.galeri.link = baseurl+'gallery.html';

  $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
    $scope.menu_footer=data;  
  });
  $http.get(baseurl+'admin/all_galeri_kategori',$scope.auth_config).success(function(data) {      
    $scope.all_galeri_kategori=data;  
  });
  
  $scope.klik_footer = function () {       
    $http.post(baseurl+'admin/footer', {role : $scope.form.role,posisi : $scope.form.posisi},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $http.get(baseurl+'admin/footer/'+$scope.form.posisi,$scope.auth_config).success(function(data) {      
          if ($scope.form.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.form.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.form.posisi == 3){
            $scope.footer_kolom3=data;
          }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_footer_slider = function () {       
    $http.post(baseurl+'admin/footer', {role : 9,posisi : $scope.galeri.posisi,id_galeri_kategori :$scope.galeri.galeri_kategori },$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $http.get(baseurl+'admin/footer/'+$scope.galeri.posisi,$scope.auth_config).success(function(data) {      
          if ($scope.galeri.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.galeri.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.galeri.posisi == 3){
            $scope.footer_kolom3=data;
          }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kategori = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kategoris.judul,link : $scope.kategoris.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.kategoris.link ='';
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });
        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  

  $scope.klik_sitemap = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.sitemap.judul,link : $scope.sitemap.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Tambahan Di Tambah');                
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_galeri = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.galeri.judul,link : $scope.galeri.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Tambahan Di Tambah');
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  $scope.klik_custom_link = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.custom.judul,link : $scope.custom.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu_footer Di tambah');
        $scope.custom =[];        
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_blog = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.blog.judul,link : $scope.blog.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Tambahan Di tambah');                
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  
  ///
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
      $http.delete(baseurl+'admin/menu_footer/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Menu Footer');                
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
        
    });
  };

  $scope.edit = function (id) {
    $http.get(baseurl+'admin/menu_footer/'+id,$scope.auth_config).success(function(data) {      
      $scope.get_menu_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_menu_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_menu_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/menu_footer/'+id, response,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Menu Footer');
          $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
            $scope.menu_footer=data;  
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

  ///

  $scope.footer_delete = function (posisi,id) {
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
      $http.delete(baseurl+'admin/footer/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Footer');                
        $http.get(baseurl+'admin/footer/'+posisi,$scope.auth_config).success(function(data) {      
          if (posisi == 1) {
            $scope.footer_kolom1=data;
          }if(posisi == 2){
            $scope.footer_kolom2=data;
          }if(posisi == 3){
            $scope.footer_kolom3=data;
          }

        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
        
    });
  };

  $scope.footer_edit = function (posisi,id) {
    $http.get(baseurl+'admin/get_footer/'+id,$scope.auth_config).success(function(data) {      
      $scope.get_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/footer/'+id, response,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Footer');
          $http.get(baseurl+'admin/footer/'+posisi,$scope.auth_config).success(function(data) {      
            if (posisi == 1) {
              $scope.footer_kolom1=data;
            }if(posisi == 2){
              $scope.footer_kolom2=data;
            }if(posisi == 3){
              $scope.footer_kolom3=data;
            }
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

}]); 

app.controller('Footer', ['$scope','$http','toaster','$modal','$state','$timeout', function($scope,$http,toaster,$modal,$state,$timeout) {
  $scope.load_sign();

  $scope.status = {};
  $scope.status.kolom1 = true;
  $scope.status.kolom2 = true;
  $scope.status.kolom3 = true;

  $scope.oneAtATime = false;
  $scope.oneAtATimes = true;
  $scope.form = [];
  $scope.list_kolom = [
    {judul:'Sosial Media',role:1},
    {judul:'Kontak',role:2},
    {judul:'Logo',role:3},
    {judul:'Deskripsi',role:4},    
    {judul:'Categorys',role:5},
    
    {judul:'Special Offer',role:7},
    {judul:'Menu',role:8},
    {judul:'Map',role:11},
    {judul:'List Blog',role:12}
  ];
  $scope.custom =[]
    
  $scope.blog =[];
  $scope.blog.judul = 'blog';
  $scope.blog.link = baseurl+'blog'; 

  $scope.sitemap =[];
  $scope.sitemap.judul = 'sitemap';
  $scope.sitemap.link = baseurl+'sitemap.xml';

  $scope.galeri =[];
  $scope.kategori =[];
  $scope.galeri.judul = 'galeri';
  $scope.galeri.link = baseurl+'gallery';

  $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
    $scope.menu_footer=data;  
  });
  $http.get(baseurl+'admin/all_galeri_kategori',$scope.auth_config).success(function(data) {      
    $scope.all_galeri_kategori=data;  
  });
  $http.get(baseurl+'admin/footer/'+1,$scope.auth_config).success(function(data) {      
    $scope.footer_kolom1=data;  
  });
  $http.get(baseurl+'admin/footer/'+2,$scope.auth_config).success(function(data) {      
    $scope.footer_kolom2=data;  
  });
  $http.get(baseurl+'admin/footer/'+3,$scope.auth_config).success(function(data) {      
    $scope.footer_kolom3=data;  
  });
  $http.get(baseurl+'admin/all_kategori',$scope.auth_config).success(function(data) {
      $scope.kategori_paket_tour=data;    
    }); 
  $scope.klik_footer = function () {       
    $http.post(baseurl+'admin/footer', {role : $scope.form.role,posisi : $scope.form.posisi},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/footer/'+$scope.form.posisi,$scope.auth_config).success(function(data) {      
          if ($scope.form.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.form.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.form.posisi == 3){
            $scope.footer_kolom3=data;
          }
          $timeout(function(){
            $scope.form =[];
          }, 100); 
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_paket_tour = function () {       
    $http.post(baseurl+'admin/footer', {role : 10,posisi : $scope.kategori.posisi,id_galeri_kategori :$scope.kategori.paket_tour_kategori },$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        
        $http.get(baseurl+'admin/footer/'+$scope.kategori.posisi,$scope.auth_config).success(function(data) {      
          if ($scope.kategori.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.kategori.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.kategori.posisi == 3){
            $scope.footer_kolom3=data;
          }
          $scope.kategori =[];
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_footer_slider = function () {       
    $http.post(baseurl+'admin/footer', {role : 9,posisi : $scope.galeri.posisi,id_galeri_kategori :$scope.galeri.galeri_kategori },$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/footer/'+$scope.galeri.posisi,$scope.auth_config).success(function(data) {                
          if ($scope.galeri.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.galeri.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.galeri.posisi == 3){
            $scope.footer_kolom3=data;
          }
          $timeout(function(){
            $scope.form =[];
          }, 100);
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kategori = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kategoris.judul,link : $scope.kategoris.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.kategoris.link ='';
        $http.get(baseurl+'admin/menu',$scope.auth_config).success(function(data) {      
          $scope.menu=data;  
        });
        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  

  $scope.klik_sitemap = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.sitemap.judul,link : $scope.sitemap.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Footer Di Tambah');                
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_galeri = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.galeri.judul,link : $scope.galeri.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Footer Di Tambah');
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  $scope.klik_custom_link = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.custom.judul,link : $scope.custom.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu_footer Di tambah');
        $scope.custom =[];        
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_blog = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.blog.judul,link : $scope.blog.link},$scope.auth_config)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Footer Di tambah');                
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  
  ///
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
      $http.delete(baseurl+'admin/menu_footer/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Menu Footer');                
        $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
          $scope.menu_footer=data;  
        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
        
    });
  };

  $scope.edit = function (id) {
    $http.get(baseurl+'admin/menu_footer/'+id,$scope.auth_config).success(function(data) {      
      $scope.get_menu_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_menu_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_menu_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/menu_footer/'+id, response,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Menu Footer');
          $http.get(baseurl+'admin/menu_footer',$scope.auth_config).success(function(data) {      
            $scope.menu_footer=data;  
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

  ///

  $scope.footer_delete = function (posisi,id) {
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
      $http.delete(baseurl+'admin/footer/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Footer');                
        $http.get(baseurl+'admin/footer/'+posisi,$scope.auth_config).success(function(data) {      
          if (posisi == 1) {
            $scope.footer_kolom1=data;
          }if(posisi == 2){
            $scope.footer_kolom2=data;
          }if(posisi == 3){
            $scope.footer_kolom3=data;
          }

        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
        
    });
  };

  $scope.footer_edit = function (posisi,id) {
    $http.get(baseurl+'admin/get_footer/'+id,$scope.auth_config).success(function(data) {      
      $scope.get_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/footer/'+id, response,$scope.auth_config)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Footer');
          $http.get(baseurl+'admin/footer/'+posisi,$scope.auth_config).success(function(data) {      
            if (posisi == 1) {
              $scope.footer_kolom1=data;
            }if(posisi == 2){
              $scope.footer_kolom2=data;
            }if(posisi == 3){
              $scope.footer_kolom3=data;
            }
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

}]); 

app.controller('modal_menu_footer', ['$scope', '$modalInstance', 'items', function($scope, $modalInstance, items) {
  $scope.items = items;
  $scope.ok = function () {    
    $modalInstance.close($scope.items);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]); 

