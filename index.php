<?php include('header.php'); ?>
<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cars";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
	die("could not connect: " . $conn->connect_error);
}
$sql = "SELECT * FROM cars ORDER BY car_id DESC";
$result = $conn->query($sql);
$num = $result->num_rows;
if ($num > 0) {
?>
	<div class="container cars">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="count"><span><?php echo $num; ?></span> Total Cars</h3>
			</div>
			<?php
			while ($row = $result->fetch_assoc()) {
				$comp_query = "SELECT name, logo FROM agency WHERE agency_id=" . $row['posted_by'];
				$result_comp = $conn->query($comp_query);
				if ($result_comp->num_rows > 0) {
					$comp_name = $result_comp->fetch_assoc();
					$agency_name = $comp_name['name'];
					$agency_logo = "img/" . $comp_name['logo'];
				} else {
					$company_name = "Untitled";
					$agency_logo = "img/car_logo.png";
				}
				$date_query = "SELECT date FROM cars_posted WHERE car_id=" . $row['car_id'];
				$result_date = $conn->query($date_query);
				if ($result_date->num_rows > 0) {
					$date_name = $result_date->fetch_assoc();
					$post_date = $date_name['date'];
				} else {
					$post_date = "";
				}
			?>
				<div class="col-sm-6">
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
										<th>Car Number</th>
										<th>Seating Capacity</th>
										<th>Rent</th>
										<th>Posted On</th>
									</tr>
									<tr>
										<td><?php echo $row['number']; ?></td>
										<td><?php echo $row['seats']; ?></td>
										<td><?php echo $row['rent'] . " per day"; ?></td>
										<td><?php echo $post_date; ?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="show-more">
							<?php
							if ($_SESSION) {
								$user_id = $_SESSION['user_id'];
								$query = "SELECT booking_date FROM cars_booked WHERE car_id=" . $row['car_id'] . " AND customer_id=" . $user_id;
								$result2 = $conn->query($query);
								if ($result2->num_rows > 0) { ?>
									<button class="btn disabled" disabled="disabled">ALREADY BOOKED</button>
								<?php	} else if ($_SESSION['type'] == 'agency') { ?>
									<form action="connect.php" method="post">
										<input type="hidden" value="<?php echo $row['car_id']; ?>" name="car_id" />
										<button type="submit" class="btn" name="rent_car">RENT CAR</button>
									</form>
								<?php } else { ?>
									<a href="#" class="custom-btn" data-toggle="modal" id="rent_car_btn" data-target="#rent_car" data-car-id="<?php echo $row['car_id']; ?>">RENT CAR</a>
								<?php }
							} else { ?>
								<form action="connect.php" method="post">
									<input type="hidden" value="<?php echo $row['car_id']; ?>" name="car_id" />
									<button type="submit" class="btn" name="rent_car">RENT CAR</button>
								</form>
							<?php }  ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>

	<div class="modal" id="rent_car">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="container">
					<div class="form">
						<form action="connect.php" method="post">
							<input type="hidden" id="car_id_modal" name="car_id" />
							<div class="form-group">
								<label for="start_date">Start Date</label>
								<input type="date" class="form-control" id="start_date" name="start_date" required />
							</div>
							<div class="form-group">
								<label for="days">Number of days</label>
								<input type="number" class="form-control" value="1" id="days" name="days" min="1" max="1000" required />
							</div>
							<button type="submit" class="btn btn-primary" name="rent_car">RENT CAR</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php include('footer.php'); ?>