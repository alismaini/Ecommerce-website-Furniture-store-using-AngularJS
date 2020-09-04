<?php
session_start();



?>
<!DOCTYPE html>
<html>
<head>
	<title>Grocery store</title>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Bootstrap Css-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">

	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

	<link rel="stylesheet" type="text/css" href="./assets/CSS/main.css">
   <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand h1" href="index.php"><i class="fas fa-couch" aria-hidden="true"></i> Furniture Store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
</nav>

<div class="container">
  <h1 class="text-center text-white bg-dark"> Order Placed Succesfully</h1>
  <br>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      
        <?php

        $con= mysqli_connect('localhost','root','','shoporder');
        

        if(isset($_POST['submit'])){

          $username = trim($_POST['name']);
          $email = trim($_POST['email']);
          $mobile = trim($_POST['mobile']);
          $type = trim($_POST['type']);
          

          print_r($username);
          echo "<br>";
          //print_r($files);

          

            $q = "INSERT INTO `orders`( `username`, `email`, `mobile`, `type`) VALUES ('$username','$email','$mobile','$type')";

            $query = mysqli_query($con,$q);
             $displayquery = "select orderid,username,email,mobile,type from orders where username=?";
             $stmt = $con->prepare($displayquery);
             $stmt -> bind_param("i",$username);
             $stmt->execute();
             $result = $stmt->get_result();
             $user = $result->fetch_assoc();
            $querydisplay = mysqli_query($con,$displayquery);

            //$row= mysqli_num_rows($querydisplay);
            echo "Your order has been placed successfully". "<br>";
            echo "Your order id  is:";
            echo $user['orderid'];
            

          }
        

        ?>

    </table>
    <div class="container" ng-app="shoppingCart" ng-controller="shoppingCartController" ng-init="loadProduct(); fetchCart();">
      <h3 align="center"> <i class="fas fa-shopping-basket"></i> Your Order Details</h3>
    <div class="table-responsive" id="order_table">
        <table class="table table-bordered table-striped">
          <tr>  
            <th width="40%">Product Name</th>  
            <th width="10%">Quantity</th>  
            <th width="20%">Price</th>  
            <th width="15%">Total</th>  
              
          </tr>
          <tr ng-repeat = "cart in carts">
            <td>{{cart.product_name}}</td>

            <td>{{cart.product_quantity}}</td>
            <td>{{cart.product_price}}</td>
            <td>{{cart.product_quantity * cart.product_price}}</td>
            
          </tr>
          <tr>
            <td colspan="3" align="right">Total</td>
            <td colspan="2">{{ setTotals() }}</td>
          </tr>
        </table>
      </div>
  </div>
</div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>
</body>
</html>

<script>

var app = angular.module('shoppingCart', []);

app.controller('shoppingCartController', function($scope, $http){
  
  $scope.loadProduct = function(){
    $http.get('fetch.php').success(function(data){
            $scope.products = data;
        })
  };
  
  $scope.carts = [];
  
  $scope.fetchCart = function(){
    $http.get('fetch_cart.php').success(function(data){
            $scope.carts = data;
        })
  };
  
  $scope.setTotals = function(){
    var total = 0;
    for(var count = 0; count<$scope.carts.length; count++)
    {
      var item = $scope.carts[count];
      total = total + (item.product_quantity * item.product_price);
    }
    return total;
  };
  
  $scope.addtoCart = function(product){
    $http({
            method:"POST",
            url:"add_item.php",
            data:product
        }).success(function(data){
      $scope.fetchCart();
        });
  };
  
  $scope.removeItem = function(id){
    $http({
            method:"POST",
            url:"remove_item.php",
            data:id
        }).success(function(data){
      $scope.fetchCart();
        });
  };
  
});

</script>