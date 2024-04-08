<?php include('header.php'); ?>

<?php 
		$user_id=$_SESSION['user_id'];
		$type=$_SESSION['type'];
		$dbhost="localhost";	
		$dbuser="root";
		$dbpass="";
		$dbname="cars";		
		$conn=new mysqli($dbhost,$dbuser,$dbpass,$dbname);
		if($conn->connect_error)
		{
		die("could not connect: ".$conn->connect_error);
		}
?>


<section class="container main">
<div class="row">

		<?php if($type=="agency")
			{?>
	<div class="col-sm-7 ">
	<h4 class="no_posts">CARS added by you</h4>
	<?php
		$query="SELECT name, logo FROM agency WHERE agency_id=".$user_id;
		$result=$conn->query($query);
		if($result->num_rows>0)
		{
			$row=$result->fetch_assoc();
			$company_name=$row['name'];
			$agency_logo="img/".$row['logo'];
		}
		$sql="SELECT * FROM cars WHERE posted_by=".$user_id." ORDER BY car_id DESC";
		$result=$conn->query($sql);
		if($result->num_rows>0)
		{?>
		<div class="container cars">
		<div class="row">
		<?php
			while($row=$result->fetch_assoc())
			{
			$query="SELECT date FROM cars_posted WHERE car_id=".$row['car_id'];
			$result2=$conn->query($query);
			if($result2->num_rows>0)
			{
				$row2=$result2->fetch_assoc();
				$posted_on=$row2['date'];
			}
			?>
			<div class="col-sm-12">
			<form class="edit_form" action="connect.php" method="post">
			<div class="block">
			<div class="details">
				<div class="inner-block">
				<h4 class="title"><input type="text" class="edit_field model" value="<?php echo $row['model']; ?>" name="model" readonly></h4>
				<h4 class="company-name"><?php echo $company_name; ?></h4>
				</div>
				<div class="inner-block logo">
					<img src="<?php echo $agency_logo; ?>" alt="Logo" />
				</div>

				<div class="table-responsive">
				<table class="table">
				<tr>
						<th>Vehicle Number</th>
						<th>Seating Capacity</th>
						<th>Rent per day</th>
						<th>Posted On</th>
					</tr>
					<tr>
						<input type="hidden" value="<?php echo $row['car_id']; ?>" name="car_id" >
						<td><input type="text" class="edit_field number" value="<?php echo $row['number']; ?>" name="number" readonly required></td>
						<td><input type="number" class="edit_field seats" value="<?php echo $row['seats']; ?>" name="seats" readonly required></td>
						<td><input type="number" class="edit_field rent" value="<?php echo $row['rent']; ?>" name="rent" readonly required></td>
						<td><?php echo $posted_on; ?></td>
					</tr>
				</table>
				</div>
			</div>
			<div class="show-more">
			<a href="#" class="custom-btn" onclick="edit_details(this)">EDIT DETAILS</a>
			<a href="#" class="custom-btn float-right yoyo" data-toggle="modal" data-target="#<?php echo $row['car_id']; ?>">VIEW APPLICANTS</a>
			<button name="edit_details" class="btn btn-custom d-none">Submit</button>
			</div>
			</form>
			</div>
			</div>
	<div class="modal" id="<?php echo $row['car_id']; ?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="container">
				<?php 
					$car_id= $row['car_id'];
					$get_query="SELECT customer_id, start_date, booking_date, days FROM cars_booked WHERE car_id=".$car_id;
					$result_query=$conn->query($get_query);
					if($result_query->num_rows>0)
					{
					$sno=1; ?>
					<div class="table-responsive">
					<table class="table2">
					<tr>
					<th>S no.</th>
					<th>Name</th>
					<th>Number of days</th>
					<th>Start Date</th>
					<th>Booking Date</th>
					</tr>
					<?php	while($row_query=$result_query->fetch_assoc())
						{	?>
							<tr>
							<td><?php echo $sno; ?></td>
					<?php	$get_query2="SELECT name FROM customer WHERE customer_id=".$row_query['customer_id'];
							$result_query2=$conn->query($get_query2);
							if($result_query2->num_rows>0)
							{
								$row_query2=$result_query2->fetch_assoc(); ?>
									<td><?php echo $row_query2['name']; ?></td>
									<td><?php echo $row_query['days']; ?></td>
									<td><?php echo $row_query['start_date']; ?></td>
									<td><?php echo $row_query['booking_date']; ?></td>
					<?php	}	?>
							</tr>
					<?php	$sno=$sno+1;
						}	?>
					</table>
					</div>	
				<?php	}
					else
					{	?>
						 <h5 class="no_posts">No customers booked till now.</h5>
				<?php	}
				?>
			</div>
		</div>
	</div>
</div>
			<?php } ?>
		</div>
		</div>
		<?php }
		else 
		{
		?>
		<div class="no_posts"><h3>No cars added for rental</h3><p>(Add your first car)</p></div>
		<?php 
		} ?>
		</div>
	<div class="col-sm-5">
		<h4 class="heading">Add new cars</h4>
		<form action="connect.php" method="post">
		<div class="container form2">
		<div class="row">
			<div class="col-md-6 form-group">
					<label for="model">Vehicle Model:</label>
					<input type="text" class="form-control" id="model" name="model" required />
			</div>
			<div class="col-md-6 form-group">
					<label for="number">Vehicle Number:</label>
					<input type="text" class="form-control" id="number" name="number" required />
			</div>
			<div class="col-md-6 form-group">
					<label for="seats">Seating Capacity</label>
					<input type="number" class="form-control" id="seats" name="seats" required  />
			</div>
			<div class="col-md-6 form-group">
					<label for="rent">Rent per day:</label>
					<input type="number" class="form-control" id="rent" name="rent" required />
			</div>
			<div class="col-md-12 form-group">
					<label for="description">Description:</label>
					<textarea class="form-control" id="desciption" name="description" maxlength="300" required ></textarea>
			</div>
			<div class="col-sm-12">
				<button name="add_car" class="btn btn-custom">Add Car</button>
			</div>
		</div>
		</div>
		</form>
	</div>
		<?php }
			else
			{ ?>
	<div class="col-sm-12">
		<h4 class="no_posts">CARS you rented</h4>
		<?php
		$query="SELECT car_id, days, start_date, booking_date FROM cars_booked WHERE customer_id=".$user_id;
		$result2=$conn->query($query);
		if($result2->num_rows>0)
		{?>
		<div class="container cars">
		<div class="row">
		<?php
		while($row2=$result2->fetch_assoc())
			{
				$booking_date=$row2['booking_date'];
				$start_date=$row2['start_date'];
				$days=$row2['days'];
				$sql="SELECT * FROM cars WHERE car_id=".$row2['car_id'];
		$result=$conn->query($sql);
		if($result->num_rows>0)
		{
			$row=$result->fetch_assoc();
			$comp_query="SELECT name, logo FROM agency WHERE agency_id=".$row['posted_by'];
			$result_comp=$conn->query($comp_query);
			if($result_comp->num_rows>0)
			{
				$comp_name=$result_comp->fetch_assoc();
				$agency_name=$comp_name['name'];
				$agency_logo="img/".$comp_name['logo'];
			}
			?>
			<div class="col-sm-12">
			<div class="block">
			<div class="details">
			<div class="inner-block">
			<h4 class="title"><?php echo $row['model']; ?></h4>
			<h4 class="company-name"><?php echo $agency_name; ?></h4>
			</div>
			<div class="inner-block logo">
				<img src="<?php echo $agency_logo; ?>" alt="Logo" />
			</div>
			
			<div class="table-responsive">
			<table class="table">
			<tr>
					<th>Vehicle Number</th>
					<th>Seating Capacity</th>
					<th>Rent per day</th>
					<th>Number of days</th>
					<th>Start Date</th>
					<th>Booked On</th>
				</tr>
				<tr>
					<td><?php echo $row['number']; ?></td>
					<td><?php echo $row['seats']; ?></td>
					<td><?php echo $row['rent']; ?></td>
					<td><?php echo $days; ?></td>
					<td><?php echo $start_date; ?></td>
					<td><?php echo $booking_date; ?></td>
				</tr>
			</table>
			</div>
			</div>
			<div class="show-more">
			<a href="#">view details ></a>
			</div>
			</div>
			</div>
			<?php } }?>
			</div>
		</div>
		<?php }
		else
		{ ?>
		<div class="no_posts" ><h3>No cars rented.</h3><p>(Rent your first car)</p></div>
		<?php } }?>

</div>

</div>
</section>

<?php include('footer.php'); ?>
