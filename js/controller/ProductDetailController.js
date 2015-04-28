angular.module('maiko').controller('ProductDetailController',['$scope','IMAGE',function($scope,image){
	$scope.image=image;
	$scope.validateStock=function(before){
		  if($scope.product.quantity==''){
            return;
        }
        else if($scope.product.quantity<1)
            $scope.product.quantity= before;
        else if($scope.product.stock<$scope.product.quantity)
           $scope.product.quantity= before;
        if(typeof $scope.product.quantity==='undefined')
            $scope.product.quantity='';
        
	};
}]);