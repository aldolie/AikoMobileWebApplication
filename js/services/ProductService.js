


angular.module('maiko').factory('ProductService',['$http','$rootScope','$q','Base64','SERVICE',function($http,$rootScope,$q,Base64,api){
	

	(function authentication(){
		  $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode('administrator' + ':' + 'KJHASDF89.ajHFAHF$');
	})();
	
	function ProductService(){
		
	}
	
	ProductService.prototype={
		constructor:ProductService,
		loadProductsReady:function(o,l){
			var deferred=$q.defer();
			var url=api+'products/t/0/o/'+o+'/l/'+l;
			$http.get(url).success(function(data){
				deferred.resolve(data);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadProductsPO:function(o,l){
			var deferred=$q.defer();
			var url=api+'products/t/1/o/'+o+'/l/'+l;
			$http.get(url).success(function(data){
				deferred.resolve(data);
				$rootScope.$phase;
			});
			return deferred.promise;
		}
	}
	

	var instance=new ProductService();
	return instance;
}]);