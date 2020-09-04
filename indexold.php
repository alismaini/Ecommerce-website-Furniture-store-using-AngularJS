<?php
session_start();

?>

<!DOCTYPE html>
<html>
	<head ng-app="shoppingCart">
		<title>Grocery store</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet"> 
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
		<style>
		.popover
		{
		    width: 100%;
		    max-width: 800px;
		}
		
		</style>
	</head>
	<body>



		<nav class="navbar navbar-light bg-primary" style="
		background-color: #2908FD;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" style="font-size: 25px; color: white;" href="#"> <i class="fas fa-shopping-cart"></i> Grocery store</a>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a class="navbar-brand" style="font-size: 18px; color: white;" href="adminlogin.php"> <i class="fas fa-shopping-user"></i> Admin</a>
    </div>

  </div><!-- /.container-fluid -->
</nav>




		<div class="container" ng-app="shoppingCart" ng-controller="shoppingCartController" ng-init="loadProduct(); fetchCart();">
			<br />
			<h3 align="center">Products On Sale</h3>
			<br />
			<form method="post">
				<div class="row">
					<div class="col-md-3" style="margin-top:12px;" ng-repeat = "product in products">
						<div style="box-shadow: 2px; background-color:#f1f1f1; border-radius:5px; padding:16px; height:450px;" align="center">
							<img ng-src="images/{{product.image}}" class="img-responsive" style="width: 200px; height: 200px;" /><br />
							<h4 class="text-info">{{product.name}}</h4>
							<h4 class="text-danger">{{product.price}}</h4><br>
							<input type="button" name="add_to_cart" style="margin-top:5px;" class="btn btn-warning form-control" value="Add to Cart" ng-click="addtoCart(product)" />
						</div>
					</div>
				</div>
			</form>
			<br /><br><br>
			<h3 align="center"> <i class="fas fa-shopping-basket"></i> Your Cart Details</h3>
			<div class="table-responsive" id="order_table">
				<table class="table table-bordered table-striped">
					<tr>  
						<th width="40%">Product Name</th>  
						<th width="10%">Quantity</th>  
						<th width="20%">Price</th>  
						<th width="15%">Total</th>  
						<th width="5%">Action</th>  
					</tr>
					<tr ng-repeat = "cart in carts">
						<td>{{cart.product_name}}</td>

						<td>{{cart.product_quantity}}</td>
						<td>{{cart.product_price}}</td>
						<td>{{cart.product_quantity * cart.product_price}}</td>
						<td><button type="button" name="remove_product" class="btn btn-danger btn-xs" ng-click="removeItem(cart.product_id)">Remove</button></td>
					</tr>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td colspan="2">{{ setTotals() }}</td>
					</tr>
				</table>
				<div style="padding-bottom: 3%;">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" value="order" name="order">
  Order Now
</button></div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">order details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="buy.php" method="POST" enctype="multipart/form-data">
  <div class="form-group" action="adminmainpage.php">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" required>
    <small id="emailHelp" class="form-text text-muted">Enter Full name.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mobile Number</label>
    <input type="Number" class="form-control" id="exampleInputPassword1" name="mobile" required>
    <label for="exampleInputPassword1">EmailId</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="email" required>
    <small id="emailHelp" class="form-text text-muted">Enter Email</small>
    <label><b>Delivery type:</b> </label><br>
    <input type="radio" id="homedelivery" name="type" value="homedelivery">
        <label for="homedelivery">Home Delivery</label><br>
  <input type="radio" id="selfpickup" name="type" value="selfpickup">
  <label for="selfpickup">Self Pickup</label><br>
  </div>
  
  <button type="submit" value="Click" id="electrician"  name="submit" class="btn btn-primary" ng-click="insertdata()">Order Now </button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
			</div>
		</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>

<script>



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