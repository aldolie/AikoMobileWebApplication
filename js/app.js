var app=angular.module('maiko',[]);
app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});
app.constant('SERVICE','http://localhost/aiko/index.php/services/');
app.constant('IMAGE','http://localhost/aiko/image/items/');
app.constant('BASE','http://localhost/mobileaiko/');


angular.module('maiko').controller('General',['$scope','IMAGE',function($scope,image){
	$scope.image=image;
}])