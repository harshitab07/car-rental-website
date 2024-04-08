<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<title>Car Rental Service</title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic|Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'/>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css"  />
</head>
<body>
<div class="modal" id="login">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="container">
	<div class="row modal-title">
		<div class="col-sm-6 on" name="customer">
			Customer
		</div>
		<div class="col-sm-6" name="agency">
			Car Agency
		</div>
	</div>
	<div class="form">
		<form action="connect.php"  method="post">
			<input type="hidden" value="customer" id="login_type" class="type"  name="login_user_type" />
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="login_email" name="login_email" required/>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="login_password" name="login_password" required/>
			</div>
			<button type="submit" class="btn btn-primary" name="login_btn" >Login</button>
		</form>
	</div>
	</div>
	</div>
	</div>
</div>
<div class="modal" id="register">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="container">
	<div class="row modal-title">
		<div class="col-sm-6 on" name="customer">
			Customer
		</div>
		<div class="col-sm-6 " name="agency">
			Car Agency
		</div>
	</div>
	<div class="form">
		<form action="connect.php"  method="post" id="customer_register"> 
			<input type="hidden" value="customer"  name="type"/>
		<div class="register" >
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" name="customer_name" required/>
			</div>
			<div class="form-group">
				<label for="phone">Phone</label>
				<input type="text" class="form-control" id="phone" name="customer_phone" required/>
			</div>
			<div class="form-group">
				<label for="address">Address</label>
				<input type="text" class="form-control" id="address" name="customer_address" required/>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="customer_email" required/>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="customer_password" required/>
			</div>
		</div>	
		</form>
		<form action="connect.php"  method="post" id="agency_register"  enctype="multipart/form-data"> 
		<div class="register hidden" >
			<input type="hidden" value="agency"  name="type"/>
			<div class="form-group">
				<label for="name">Agency name</label>
				<input type="text" class="form-control" id="name" name="agency_name" required/>
			</div>
			<div class="form-group">
				<label for="phone">Phone</label></label>
				<input type="text" class="form-control" id="phone" name="agency_phone" required />
			</div>
			<div class="form-group">
				<label for="agency_logo">Logo</label></label>
				<input type="file" class="form-control" id="agency_logo" accept="image/*" name="agency_logo" required />
			</div>
			<div class="form-group">
				<label for="address">Address</label></label>
				<input type="text" class="form-control" id="address" name="agency_address" required />
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="agency_email" required/>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="agency_password"/>
			</div>
		</div>	
			<button type="submit" class="btn btn-primary" name="register_btn" id="submit_registration" form="customer_register">Register</button>
		</form>
	</div>
	</div>
	</div>
	</div>
</div>


<header class="container-fluid">
<div class="container">
<div class="row">
	<div class="col-sm-3 logo">
		<a href="/"><img src="img/car_logo.png" /></a>
	</div>
	<div class="col-sm-9">
		<ul class="menu">
			<?php 
				if(!$_SESSION)
				{?>
			<li><a href="#" class="custom-btn" data-toggle="modal" data-target="#login">Login</a></li>
			<li><a href="#" class="custom-btn" data-toggle="modal" data-target="#register">Register</a></li>
			<?php }
				else
				{
				?>
			<li class="dropdown"><?php echo $_SESSION['name']; ?> <span class="fa fa-caret-down"></span>
					<ul>
						<li>Registered as: <?php echo ucwords($_SESSION['type']); ?></li>
						<a href="index.php"><li>Rent Cars</li></a>
						<a href="dashboard.php"><li>Dashboard</li></a>
						<a href="connect.php"><li>Log out</li></a>
					</ul>
			</li>
			<?php 
				}
			?>
		</ul>
	</div>
</div>
</div>
</header>