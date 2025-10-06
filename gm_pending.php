<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>General Manager - Pending Requests</title>
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<style>
		.btn-approve, .btn-reject {
			padding: 4px 8px;
			border-radius: 5px;
			color: #fff;
			text-decoration: none;
			font-size: 13px;
		}
		.btn-approve { background: #28a745; }
		.btn-reject { background: #dc3545; }
	</style>
</head>
<body>

<!-- SIDEBAR -->
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bx-user-voice'></i>
		<span class="text">GM Panel</span>
	</a>
	<ul class="side-menu top">
		<li>
			<a href="gm_dashboard.php">
				<i class='bx bx-grid-alt'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li class="active">
			<a href="gm_pending.php">
				<i class='bx bx-time-five'></i>
				<span class="text">Pending Requests</span>
			</a>
		</li>
	</ul>
	<ul class="side-menu">
		<li>
			<a href="logout.php" class="logout">
				<i class='bx bx-log-out'></i>
				<span class="text">Logout</span>
			</a>
		</li>
	</ul>
</section>

<!-- CONTENT -->
<section id="content">
	<nav>
		<i class='bx bx-menu'></i>
		<a href="#" class="nav-link">Pending Requests</a>
	</nav>

	<main>
		<div class="head-title">
			<div class="left">
				<h1>Pending Leave Requests</h1>
				<ul class="breadcrumb">
					<li><a href="gm_dashboard.php">Dashboard</a></li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li><a href="#" class="active">Pending</a></li>
				</ul>
			</div>
		</div>

		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Requests Awaiting GM Decision</h3>
				</div>
				<table>
					<thead>
						<tr>
							<th>Date Filed</th>
							<th>Type</th>
							<th>Employee</th>
							<th>Department</th>
							<th>GM Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$res = $conn->query("SELECT * FROM leave_applications 
											WHERE dept_head_status='Approved' AND gm_status='Pending'");
						while ($row = $res->fetch_assoc()) {
							echo "<tr>
								<td>".date('F j, Y', strtotime($row['filing_date']))."</td>
								<td>".$row['leave_type']."</td>
								<td>".$row['full_name']."</td>
								<td>".$row['department_head']."</td>
								<td><span class='status pending'>".$row['gm_status']."</span></td>
								<td>
									<a href='gm_approved.php?id=".$row['id']."' class='btn-approve'>Approve</a>
									<a href='gm_reject.php?id=".$row['id']."' class='btn-reject'>Reject</a>
								</td>
							</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
</section>

<script>
	const menuToggle = document.querySelector(".bx-menu");
	const sidebar = document.querySelector("#sidebar");
	menuToggle.addEventListener("click", () => sidebar.classList.toggle("hide"));
</script>
</body>
</html>
