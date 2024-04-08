<?php
$btn=$_SERVER['REQUEST_METHOD'];

$dbhost="localhost";	
$dbuser="root";
$dbpass="";
$dbname="cars";

$conn=new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if($conn->connect_error)
{
	die("could not connect: ".$conn->connect_error);
}

if($btn=='POST')
{
	if(isset($_POST['login_btn']))
	{
		$type=$_REQUEST['login_user_type'];
		$email=$_REQUEST['login_email'];
		$password=$_REQUEST['login_password'];
		$sql="SELECT user_id,password FROM users WHERE email='".$email."'";
		$result=$conn->query($sql);
		if($result->num_rows>0)
		{
			$row=$result->fetch_assoc();
			$pass2=$row['password'];
			$user_id=$row['user_id'];
		}
		if($password==$pass2)
		{
			$sql="SELECT name FROM ".$type." WHERE ".$type."_id=".$user_id;
			$result=$conn->query($sql);
			if($result->num_rows>0)
			{
				$row=$result->fetch_assoc();
				$name=$row['name'];
				session_start();
				$_SESSION['name']=$name;
				$_SESSION['user_id']=$user_id;
				$_SESSION['type']=$type;
				echo "<script>alert('Logged in successfully'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
			}
			else
			{
				echo "<script>alert('User type mismatch'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
			}
		}
		else
		{
		echo "<script>alert('You are not registered. Register first.'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
		}
	}
	else if(isset($_POST['register_btn']))
	{
		$type=$_REQUEST['type'];
		if($type=="customer")
		{
			$email=$_REQUEST['customer_email'];
			$password=$_REQUEST['customer_password'];
			$name=$_REQUEST['customer_name'];
			$phone=$_REQUEST['customer_phone'];
			$address=$_REQUEST['customer_address'];
		}
		else
		{
			$email=$_REQUEST['agency_email'];
			$password=$_REQUEST['agency_password'];
			$name=$_REQUEST['agency_name'];
			$phone=$_REQUEST['agency_phone'];
			$logo=$_FILES["agency_logo"]["name"];
			$address=$_REQUEST['agency_address'];
		}
		$sql="INSERT INTO users(type,email,password) values('".$type."','".$email."','".$password."')"; 
		if (isset($_FILES["agency_logo"])) {
			$targetDirectory = "img/";
			$targetFile = $targetDirectory . basename($_FILES["agency_logo"]["name"]);
			if (!move_uploaded_file($_FILES["agency_logo"]["tmp_name"], $targetFile)) {
				echo "<script>alert('Registration unsuccessful'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
			} 
		}
		else if($type=="agency"){
			echo "<script>alert('Registration unsuccessful'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
		}
		if($conn->query($sql)===TRUE)
		{
			$last_id=$conn->insert_id;
			if($type=="customer")
				$query="INSERT INTO ".$type." (customer_id, name, phone, address) values(".$last_id.",'".$name."', '".$phone."', '".$address."')";
			else
				$query="INSERT INTO ".$type." (agency_id, name, phone, logo, address) values(".$last_id.",'".$name."','".$phone."', '".$logo."', '".$address."')";
			if($conn->query($query)===TRUE)
			{
				session_start();
				$_SESSION['name']=$name;
				$_SESSION['user_id']=$last_id;
				$_SESSION['type']=$type;
				echo "<script>alert('Registered successfully'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
			}
			else
				echo "<script>alert('Registration unsuccessful'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
		}
		else
		{
		echo "<script>alert('Registration unsuccessful.'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
		}
	}
	else if(isset($_POST['add_car']))
	{
		session_start();
		$user_id=$_SESSION['user_id'];
		$date=date("Y/m/d");
		$model=$_REQUEST['model'];
		$seats=$_REQUEST['seats'];
		$number=$_REQUEST['number'];
		$rent=$_REQUEST['rent'];
		$description=$_REQUEST['description'];
		$sql="INSERT INTO cars(model,number,seats,rent,description,posted_by) values('".$model."','".$number."','".$seats."','".$rent."','".$description."',".$user_id.")";
		if($conn->query($sql)===TRUE)
		{
			$last_id=$conn->insert_id;
			$sql="INSERT INTO cars_posted(car_id,agency_id,date) values(".$last_id.",".$user_id.",'".$date."')";
				if($conn->query($sql)==TRUE)
					echo "<script>alert('Added successfully'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
				else
					echo "<script>alert('Some error occurred.'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";	
		}
		else
		{
			echo "<script>alert('Unable to add. Please try again.'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
		}
	}
	else if(isset($_POST['rent_car']))
	{
		$car_id=$_REQUEST['car_id'];
		$start_date=$_REQUEST['start_date'];
		$days=$_REQUEST['days'];
		session_start();
		if($_SESSION)
		{
			$type=$_SESSION['type'];
			if($type=='agency')
			{
				echo "<script>alert('Car Agency cannot rent cars.'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
			}
			else
			{
				$user_id=$_SESSION['user_id'];
				$booking_date=date("Y/m/d");
				$sql="INSERT INTO cars_booked(car_id, customer_id, days, start_date, booking_date) values(".$car_id.",".$user_id.",".$days.", '".$start_date."', '".$booking_date."')";
				if($conn->query($sql)==TRUE)
				 echo "<script>alert('Rented successfully'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
				else
				 echo "<script>alert('Please try again'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
			 }
		}
		else
		echo "<script>alert('You need to login first.'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
	}
	else if(isset($_POST['edit_details'])){
		$car_id=$_REQUEST['car_id'];
		$model=$_REQUEST['model'];
		$seats=$_REQUEST['seats'];
		$number=$_REQUEST['number'];
		$rent=$_REQUEST['rent'];
		$sql="UPDATE `cars` SET `model`='".$model."',`number`='".$number."',`seats`=".$seats.",`rent`=".$rent." WHERE car_id=".$car_id;
		if($conn->query($sql)===TRUE)
			echo "<script>alert('Updated successfully'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
		else
			echo "<script>alert('Some error occurred.'); window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
	}
}
else
{
	session_start();
	session_unset();
	session_destroy();
	header('Location:http://localhost/Car Rental Service/');
}


?>