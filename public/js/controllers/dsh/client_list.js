'use strict';

app.controller('Client', ['$scope','$http','toaster',  function($scope, $http,toaster) {
	$scope.data = {}

	$scope.load = () => {
		$http.get(baseurl+'admin/client',$scope.auth_config).success((data) => {
			$scope.data = data
		});
	}
	$scope.load()

	$scope.oneAtATime = true;

	$scope.form = {}
    $scope.files = [];
    $scope.files_up = [];

	$scope.add = () => {
		$http({
			method  : 'POST',
			url     : baseurl+'admin/do/upload/gambar',    
			transformRequest: function (data) {
			    var formData = new FormData();
			    formData.append("file", $scope.files[0]); 
			    return formData;
			},		
			headers: $scope.auth_config_photo
		}).success(function(data){
			console.log(data.data)
			$scope.form.image = data.data

			$http.post(baseurl+'admin/client',$scope.form,$scope.auth_config).success(() => {
				toaster.pop('success','Berhasil Menambah Client')
				$scope.load()
				$scope.form = {}
    			$scope.files = [];		
        		$scope.image_source = ''
			}).error((xhr)=>{
				if (xhr.error) {
					toaster.pop('warning',xhr.error)	
				}else if(xhr.name){
					toaster.pop('warning',xhr.name[0])	
				}else if(xhr.domain){
					toaster.pop('warning',xhr.domain[0])					
				}
			})
		})
	}

	$scope.update = (index) => {
		$http({
			method  : 'POST',
			url     : baseurl+'admin/do/upload/gambar',    
			transformRequest: function (data) {
			    var formData = new FormData();
			    formData.append("file", $scope.files_up[0]); 
			    return formData;
			},		
			headers: $scope.auth_config_photo
		}).success(function(data){
			if (data.status == 200) {
				$scope.form_up.image = data.data;
			}
			$http.put(baseurl+'admin/client/'+$scope.form_up.id,$scope.form_up,$scope.auth_config).success(() => {
				toaster.pop('success','Berhasil Merubah Client')
				$scope.form_up = {}
	    		$scope.files_up = [];			
        		$scope.image_source_up = ''

			})
		})

	}

	$scope.changed = (index) => {
		$http.put(baseurl+'admin/client/'+$scope.data[index].id,$scope.data[index],$scope.auth_config).success(() => {
			toaster.pop('success','Berhasil Merubah Client')
		})
    }

	$scope.delete = (index) => {

		$http.delete(baseurl+'admin/client/'+$scope.data[index].id,$scope.auth_config).success(() => {
			toaster.pop('success','Berhasil Menghapus Client')
				$scope.load()
			
		})
	}

	$scope.form_up = []
	$scope.edit = (index) => {
		$scope.form_up = $scope.data[index]
		$scope.image_source_up = baseurl+'image/'+$scope.form_up.image

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

    

    $scope.uploadedUpdate = function(element) {

      $scope.currentFile = element.files[0];
      var reader = new FileReader();

      reader.onload = function(event) {
        $scope.image_source_up = event.target.result
        $scope.$apply(function($scope) {
          $scope.files_up = element.files;
        });
      }
		    
      reader.readAsDataURL(element.files[0]);
    }

}])