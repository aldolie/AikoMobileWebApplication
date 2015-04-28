angular.module('maiko').controller('ProductPOController',['$scope','ProductService','IMAGE',function($scope,ProductService,image){
	$scope.products=[];
	$scope.image=image;
	var offset=0;
	var limit=20;
	var count=20;
	var loadProduct=function(o,l){
		ProductService.loadProductsPO(o,l).then(function(data){
			data.result.forEach(function(value,key){
				$scope.products.push(value);
			});
			count=data.next;
			offset+=limit;
		});
	};
	loadProduct(0,20);

	$scope.loadMore=function(){
		loadProduct(offset,limit);
	};
	$scope.isAvailable=function(){
		if(count>0)
			return true;
		else
			return false;
	}

	$scope.clean=function(word){
		return word.replace(" ","_");
	}
}]);