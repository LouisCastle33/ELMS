<?php
include 'db_connect.php';

// Handle filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m'); // default current month (YYYY-MM)

// Build filter query
$filter_sql = "WHERE 1";
if (!empty($search)) {
    $filter_sql .= " AND full_name LIKE '%$search%'";
}
if (!empty($month)) {
    $filter_sql .= " AND (DATE_FORMAT(filing_date, '%Y-%m') = '$month')";
}

// Counts for summary boxes
$pending_count = $conn->query("SELECT COUNT(*) AS c FROM leave_applications WHERE hr_status='Pending'")->fetch_assoc()['c'];
$approved_count = $conn->query("SELECT COUNT(*) AS c FROM leave_applications WHERE hr_status='Approved'")->fetch_assoc()['c'];
$rejected_count = $conn->query("SELECT COUNT(*) AS c FROM leave_applications WHERE hr_status='Rejected'")->fetch_assoc()['c'];

// Get filtered results
$query = "SELECT * FROM leave_applications $filter_sql ORDER BY filing_date DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>HR Dashboard</title>
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
		<a href="#" class="nav-link">HR Dashboard</a>
	</nav>

	<main>
		<div class="head-title">
			<div class="left">
				<h1>HR Dashboard</h1>
				<p>Monthly Overview of Leave Applications</p>
			</div>
		</div>

		<!-- Summary Cards -->
		<ul class="box-info">
			<li>
				<i class='bx bx-time-five'></i>
				<span class="text">
					<h3><?= $pending_count ?></h3>
					<p>Pending Requests</p>
				</span>
			</li>
			<li>
				<i class='bx bx-check-circle'></i>
				<span class="text">
					<h3><?= $approved_count ?></h3>
					<p>Approved Requests</p>
				</span>
			</li>
			<li>
				<i class='bx bx-x-circle'></i>
				<span class="text">
					<h3><?= $rejected_count ?></h3>
					<p>Rejected Requests</p>
				</span>
			</li>
		</ul>

		<!-- Filter and Search -->
		<div class="filter-container" style="margin: 20px 0;">
			<form method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
				<input type="text" name="search" placeholder="Search by employee name..." value="<?= htmlspecialchars($search) ?>" style="padding: 5px 10px;">

				<label>Month:</label>
				<input type="month" name="month" value="<?= $month ?>" style="padding: 5px;">

				<button type="submit" class="btn" style="background:#007bff;color:#fff;padding:6px 12px;border:none;border-radius:4px;cursor:pointer;">Filter</button>
				<a href="hr_dashboard.php" style="color:#555;">Reset</a>
			</form>
		</div>

		<!-- Recent Leave Applications -->
		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Leave Applications for <?= date('F Y', strtotime($month . '-01')) ?></h3>
			</div>
			<table>
				<thead>
					<tr>
						<th>Date Filed</th>
						<th>Employee</th>
						<th>Leave Type</th>
						<th>HR Status</th>
						<th>Dept Head</th>
						<th>GM Status</th>
						<th>Final Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "<tr>
								<td>".date('F j, Y', strtotime($row['filing_date']))."</td>
								<td>".$row['full_name']."</td>
								<td>".$row['leave_type']."</td>
								<td><span class='status ".strtolower($row['hr_status'])."'>".$row['hr_status']."</span></td>
								<td><span class='status ".strtolower($row['dept_head_status'])."'>".$row['dept_head_status']."</span></td>
								<td><span class='status ".strtolower($row['gm_status'])."'>".$row['gm_status']."</span></td>
								<td><span class='status ".strtolower($row['final_status'])."'>".$row['final_status']."</span></td>
							</tr>";
						}
					} else {
						echo "<tr><td colspan='7' style='text-align:center;'>No records found for this month.</td></tr>";
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
