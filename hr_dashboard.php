

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>HR Dashboard - Batanelco ELMS</title>
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<!-- SIDEBAR -->
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bx-shield-quarter'></i>
		<span class="text">HR Panel</span>
	</a>
	<ul class="side-menu top">
		<li class="active">
			<a href="hr_dashboard.php">
				<i class='bx bx-grid-alt'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li>
			<a href="hr_pending.php">
				<i class='bx bx-time-five'></i>
				<span class="text">Pending Requests</span>
			</a>
		</li>
		<li>
			<a href="hr_approved.php">
				<i class='bx bx-check-double'></i>
				<span class="text">Approved Leaves</span>
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
	<!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu'></i>
		<a href="#" class="nav-link">Dashboard</a>
		<input type="checkbox" id="switch-mode" hidden>
	
	</nav>

	<!-- MAIN -->
	<main>
		<div class="head-title">
			<div class="left">
				<h1>HR Dashboard</h1>
				<ul class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li><a href="#" class="active">Dashboard</a></li>
				</ul>
			</div>
		</div>

		<ul class="box-info">
			<li>
				<i class='bx bx-user-check'></i>
				<span class="text">
					<h3>8</h3>
					<p>Pending Requests</p>
				</span>
			</li>
			<li>
				<i class='bx bx-calendar-check'></i>
				<span class="text">
					<h3>25</h3>
					<p>Approved Leaves</p>
				</span>
			</li>
			<li>
				<i class='bx bx-error-circle'></i>
				<span class="text">
					<h3>3</h3>
					<p>Rejected Requests</p>
				</span>
			</li>
		</ul>

		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Recent Leave Applications</h3>
				</div>
				<table>
					<thead>
						<tr>
							<th>Employee</th>
							<th>Leave Type</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<!-- Replace this with PHP/MySQL loop -->
						<tr>
							<td>Jane Santos</td>
							<td>Vacation Leave</td>
							<td><span class="status pending">Pending</span></td>
						</tr>
						<tr>
							<td>Mark Dela Cruz</td>
							<td>Sick Leave</td>
							<td><span class="status process">Under Review</span></td>
						</tr>
						<tr>
							<td>Ella Mariano</td>
							<td>Calamity Leave</td>
							<td><span class="status completed">Approved</span></td>
						</tr>
						<!-- End sample -->
					</tbody>
				</table>
			</div>
		</div>
	</main>
</section>

<script>
	const menuToggle = document.querySelector(".bx-menu");
	const sidebar = document.querySelector("#sidebar");

	menuToggle.addEventListener("click", () => {
		sidebar.classList.toggle("hide");
	});
</script>

</body>
</html>
