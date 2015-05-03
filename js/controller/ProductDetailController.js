angular.module('maiko').controller('ProductDetailController',['$scope','ProductService','IMAGE',function($scope,ps,image){
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

    $scope.download=function(){
        ps.downloadImage(image+$scope.product.gambar).then(function(data){

        },function(){

        });
    };
}]);