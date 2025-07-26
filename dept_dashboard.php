<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dept Head Dashboard</title>
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<!-- SIDEBAR -->
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bx-user-pin'></i>
		<span class="text">Department</span>
	</a>
	<ul class="side-menu top">
		<li class="active">
			<a href="dept_dashboard.php">
				<i class='bx bx-grid-alt'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li>
			<a href="dept_pending.php">
				<i class='bx bx-time-five'></i>
				<span class="text">Pending Reviews</span>
			</a>
		</li>
		<li>
			<a href="dept_approved.php">
				<i class='bx bx-check-double'></i>
				<span class="text">Approved</span>
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
		<a href="#" class="nav-link">Department Dashboard</a>
		<input type="checkbox" id="switch-mode" hidden>
		<label for="switch-mode" class="switch-mode"></label>
	</nav>

	<main>
		<div class="head-title">
			<div class="left">
				<h1>Department Head</h1>
				<ul class="breadcrumb">
					<li><a href="#">Dashboard</a></li>
				</ul>
			</div>
		</div>

		<ul class="box-info">
			<li>
				<i class='bx bx-user-check'></i>
				<span class="text">
					<h3><?= count($deptPending) ?></h3>
					<p>Pending Reviews</p>
				</span>
			</li>
			<li>
				<i class='bx bx-calendar-check'></i>
				<span class="text">
					<h3>12</h3>
					<p>Approved</p>
				</span>
			</li>
		</ul>

		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Leave Requests for Review</h3>
				</div>
				<table>
					<thead>
						<tr>
							<th>Employee</th>
							<th>Type</th>
							<th>Filed</th>
							<th>Start</th>
							<th>End</th>
							<th>Days</th>
							<th>Cash Out</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($deptPending as $row): ?>
						<tr>
							<td><?= $row['name'] ?></td>
							<td><?= $row['type'] ?></td>
							<td><?= $row['date_filed'] ?></td>
							<td><?= $row['start'] ?></td>
							<td><?= $row['end'] ?></td>
							<td><?= $row['days'] ?></td>
							<td><?= $row['convert'] ?></td>
							<td>
								<a href="#" class="apply-btn" style="padding: 6px 16px; font-size: 13px;">✅ Approve</a>
								<a href="#" class="apply-btn" style="background: var(--red); padding: 6px 16px; font-size: 13px;">❌ Reject</a>
							</td>
						</tr>
						<?php endforeach; ?>
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