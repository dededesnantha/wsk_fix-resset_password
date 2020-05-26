app.controller('WidgetLabel', ['$scope','$http','$location','toaster','$state', function($scope,$http,$location,toaster,$state) {    
    $scope.load_sign();

    $scope.form = {};
    $scope.load = true; 
    //get kategori
    $http.get(baseurl+'admin/widget/label',$scope.auth_config).success(function(data) {
      $scope.widget=data;      
      for (var i = $scope.widget.length - 1; i >= 0; i--) {
        $scope.form[$scope.widget[i].id] = $scope.widget[i].description;
      }
      $scope.load = false;
    });

    $scope.save = function() {      
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');    
      $http.put(baseurl+'admin/widget/label', $scope.form,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Membuat Widget Label');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');        
      }, function errorCallback(response) {
        toaster.pop('warning', 'Gagal','Periksa Data!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });
    }
}]);

app.controller('WidgetDataAdd', ['$scope','$http','$location','toaster','$state', function($scope,$http,$location,toaster,$state) {    
    $scope.load_sign();
    
    $scope.tinymceOptions = {
      plugins : 'advlist autolink lists link charmap anchor searchreplace visualblocks paste code',
      height: 300,
      menubar: false,
      relative_urls : false,
      remove_script_host : false,            
      toolbar_items_size: 'small',    
      toolbar: "formatselect | bold italic underline strikethrough blockquote | outdent indent bullist numlist | link unlink anchor | code"      
    };
    
    //get kategori
    $http.get(baseurl+'admin/widget/select',$scope.auth_config).success(function(data) {
      $scope.widget=data;      
    });

    $scope.save = function() {      
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');    
      $http.post(baseurl+'admin/widget_data/add', $scope.form,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Membuat Widget Data');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/widget/widget_data_all');
      }, function errorCallback(response) {
        toaster.pop('warning', 'Gagal','Periksa Data!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });
    }     
}]);


app.controller('WidgetDataEdit', ['$scope','$http','$location','$stateParams','toaster','$state', function($scope,$http,$location,$stateParams,toaster,$state) {    
    $scope.load_sign();

    $scope.tinymceOptions = {
      plugins : 'advlist autolink lists link charmap anchor searchreplace visualblocks paste code',
      height: 300,
      menubar: false,
      relative_urls : false,
      remove_script_host : false,            
      toolbar_items_size: 'small',    
      toolbar: "formatselect | bold italic underline strikethrough blockquote | outdent indent bullist numlist | link unlink anchor | code "      
    };
  
    
    //get kategori
    $http.get(baseurl+'admin/widget/select',$scope.auth_config).success(function(data) {
      $scope.widget=data;
      $http.get(baseurl+'admin/widget_data/edit/'+$stateParams.id,$scope.auth_config).success(function(data) {      
        $scope.form=data;        
      });  
    });


    
    $scope.save = function() {
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                    
      $http.put(baseurl+'admin/widget_data/update/'+$stateParams.id, $scope.form,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Widget');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/widget/widget_data_all');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });                
    }
   
}]);
app.controller('WidgetDataAll', ['$scope','$http','$location','$modal','toaster','$timeout','$state', function($scope,$http,$location,$modal,toaster,$timeout,$state) {    
  $scope.load_sign();

  $scope.field = [{    
    name:'All',
    target:'all'
  },{
    name:'Judul',
    target:'widget_data.name'
  },{    
    name:'Jenis',
    target:'widget.name'
  }
  ];
  $scope.form={
    much : 10,
    field : 'widget_data.name',    
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
    $http.post(baseurl+'admin/widget_data/get?page='+$scope.currentPage,$scope.form,$scope.auth_config).success(function(data) {
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
      $http.delete(baseurl+'admin/widget_data/delete/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Widget');
        $scope.load_data('paging');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
       
    });
  };
}]);


app.controller('WidgetAdd', ['$scope','$http','$location','toaster','$state', function($scope,$http,$location,toaster,$state) {    
    $scope.load_sign();

    $scope.save = function() {  
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      $http.post(baseurl+'admin/widget/add', $scope.form,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Membuat Kategori');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/widget/widget_all');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });              
    }
  
}]);

app.controller('WidgetEdit', ['$scope','$http','$location','$stateParams','toaster','$state', function($scope,$http,$location,$stateParams,toaster,$state) {    
    $scope.load_sign();  

    $http.get(baseurl+'admin/widget/edit/'+$stateParams.id,$scope.auth_config).success(function(data) {      
      $scope.form=data;      
    }); 
    
    $scope.save = function() {  
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
          $http.put(baseurl+'admin/widget/update/'+$stateParams.id, $scope.form,$scope.auth_config)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Merubah Widget');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/widget/widget_all');
          }, function errorCallback(response) {                    
            toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          });
    }


}]);

app.controller('WidgetAll', ['$scope','$http','$location','$modal','toaster','$timeout','$state', function($scope,$http,$location,$modal,toaster,$timeout,$state) {    
  $scope.load_sign();
  
  $scope.field = [{    
    name:'All',
    target:'all'
  },{
    name:'Judul',
    target:'widget.name'
  }
  ];
  $scope.form={
    much : 10,
    field : 'widget.name',    
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
    $http.post(baseurl+'admin/widget/get?page='+$scope.currentPage,$scope.form,$scope.auth_config).success(function(data) {
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
      $http.delete(baseurl+'admin/widget/delete/'+id,$scope.auth_config)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Widget');
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
