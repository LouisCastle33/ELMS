<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GM Dashboard</title>
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bx-briefcase-alt-2'></i>
		<span class="text">GM Panel</span>
	</a>
	<ul class="side-menu top">
		<li class="active">
			<a href="gm_dashboard.php">
				<i class='bx bx-grid-alt'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li>
			<a href="gm_pending.php">
				<i class='bx bx-time-five'></i>
				<span class="text">Pending</span>
			</a>
		</li>
		<li>
			<a href="gm_approved.php">
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

<section id="content">
	<nav>
		<i class='bx bx-menu'></i>
		<a href="#" class="nav-link">GM Dashboard</a>
		<input type="checkbox" id="switch-mode" hidden>
		<label for="switch-mode" class="switch-mode"></label>
	</nav>

	<main>
		<div class="head-title">
			<div class="left">
				<h1>General Manager</h1>
				<ul class="breadcrumb">
					<li><a href="#">Dashboard</a></li>
				</ul>
			</div>
		</div>

		<ul class="box-info">
			<li>
				<i class='bx bx-time-five'></i>
				<span class="text">
					<h3><?= $pending ?></h3>
					<p>Pending Reviews</p>
				</span>
			</li>
			<li>
				<i class='bx bx-check-circle'></i>
				<span class="text">
					<h3><?= $approved ?></h3>
					<p>Approved Requests</p>
				</span>
			</li>
		</ul>
	</main>
</section>

<script>
	document.querySelector(".bx-menu").addEventListener("click", () => {
		document.querySelector("#sidebar").classList.toggle("hide");
	});
</script>

</body>
</html>