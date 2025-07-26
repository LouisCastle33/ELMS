<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css" />
	<title>ELMS Dashboard</title>
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">ELMS</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="register.php">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>

	<!-- CONTENT -->
	<section id="content">
		<nav>
			<i class='bx bx-menu'></i>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
		</nav>

		<main>
			<div class="head-title">
				<div class="left">
					<h1>Welcome, Employee!</h1>
					<p>Here's your leave summary.</p>
				</div>
			</div>

			<div style="margin: 20px 0;">
				<a href="#" class="apply-btn" id="openModalBtn">
					<i class='bx bx-calendar-plus'></i>
					Apply for Leave
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-user-check'></i>
					<span class="text">
						<h3>2</h3>
						<p>Under HR Review</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-briefcase'></i>
					<span class="text">
						<h3>1</h3>
						<p>At Dept Head</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-building'></i>
					<span class="text">
						<h3>0</h3>
						<p>At Gen Manager</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-wallet'></i>
					<span class="text">
						<h3>12</h3>
						<p>Remaining Leave</p>
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
								<th>
									Date Filed
									<i class='bx bx-filter' id="filterIcon" style="cursor:pointer; margin-left:5px;"></i>
									<select id="monthFilter" style="display:none; margin-top:5px; padding:4px; border-radius:5px; border:1px solid #ccc; font-size:12px;"></select>
								</th>
								<th>Type</th>
								<th>HR Status</th>
								<th>Dept Head</th>
								<th>Gen Manager</th>
								<th>Overall</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>July 8, 2025</td>
								<td>Annual Leave</td>
								<td><span class="status pending">Pending</span></td>
								<td><span class="status process">Not yet</span></td>
								<td><span class="status process">Not yet</span></td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>June 20, 2025</td>
								<td>Sick Leave</td>
								<td><span class="status completed">Approved</span></td>
								<td><span class="status completed">Approved</span></td>
								<td><span class="status completed">Approved</span></td>
								<td><span class="status completed">Approved</span></td>
							</tr>
							<tr>
								<td>May 15, 2025</td>
								<td>Calamity Leave</td>
								<td><span class="status completed">Approved</span></td>
								<td><span class="status completed">Approved</span></td>
								<td><span class="status completed">Approved</span></td>
								<td><span class="status completed">Approved</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</main>
	</section>

	<!-- MODAL FORM -->
	<div id="leaveModal" class="modal">
		<div class="modal-content leave-form">
			<span class="close">&times;</span>
			<h3><i class='bx bx-user'></i> Leave Application Form</h3>

			<h4>Employee Information</h4>
			<div class="form-row">
				<div class="form-group">
					<label>Full Name</label>
					<input type="text" placeholder="Enter your full name">
				</div>
				<div class="form-group">
					<label>Employee ID</label>
					<input type="text" placeholder="Enter your employee ID">
				</div>
			</div>
			<div class="form-group full">
				<label>Email Address</label>
				<input type="email" placeholder="your.email@company.com">
			</div>
			<div class="form-row">
				<div class="form-group">
					<label>Department</label>
					<select>
						<option>Select department</option>
						<option>HR</option>
						<option>IT</option>
						<option>Finance</option>
					</select>
				</div>
				<div class="form-group">
					<label>Position</label>
					<input type="text" placeholder="Your job title">
				</div>
			</div>

			<h4>Leave Details</h4>
			<div class="form-group full">
				<label>Leave Type</label>
				<select>
					<option>Annual Leave</option>
					<option>Sick Leave</option>
					<option>Calamity Leave</option>
				</select>
			</div>
			<div class="form-row">
				<div class="form-group">
					<label>Start Date</label>
					<input type="date">
				</div>
				<div class="form-group">
					<label>End Date</label>
					<input type="date">
				</div>
				<div class="form-group">
					<label>Total Days</label>
					<input type="number" placeholder="1">
				</div>
			</div>
			<div class="form-group full">
				<label>Turn to Cash?</label>
				<select>
					<option>No</option>
					<option>Yes</option>
				</select>
			</div>

			<button class="submit-btn">Submit Application</button>
		</div>
	</div>

	<script src="script.js"></script>
	<script>
	// Modal open/close
	const modal = document.getElementById("leaveModal");
	const openBtn = document.getElementById("openModalBtn");
	const closeBtn = modal.querySelector(".close");

	openBtn.onclick = function () {
		modal.classList.add("visible");
		setTimeout(() => modal.classList.add("show"), 10);
	};

	closeBtn.onclick = function () {
		modal.classList.remove("show");
		setTimeout(() => modal.classList.remove("visible"), 300);
	};

	window.onclick = function (event) {
		if (event.target === modal) {
			modal.classList.remove("show");
			setTimeout(() => modal.classList.remove("visible"), 300);
		}
	};

	// FILTER ICON LOGIC
	document.getElementById("filterIcon").addEventListener("click", () => {
		const dropdown = document.getElementById("monthFilter");
		dropdown.style.display = dropdown.style.display === "none" ? "inline-block" : "none";

		if (dropdown.options.length > 1) return;

		const rows = document.querySelectorAll("tbody tr");
		const months = new Set();

		rows.forEach(row => {
			const dateCell = row.cells[0].textContent.trim(); // e.g., July 8, 2025
			const dateObj = new Date(dateCell);
			if (!isNaN(dateObj)) {
				const month = dateObj.toISOString().slice(0, 7); // 2025-07
				months.add(month);
				row.setAttribute("data-date", month); // for filtering
			}
		});

		[...months].sort().reverse().forEach(month => {
			const opt = document.createElement("option");
			const [y, m] = month.split("-");
			const monthName = new Date(`${month}-01`).toLocaleString('default', { month: 'long' });
			opt.value = month;
			opt.textContent = `${monthName} ${y}`;
			dropdown.appendChild(opt);
		});

		const allOpt = document.createElement("option");
		allOpt.value = "all";
		allOpt.textContent = "All";
		dropdown.insertBefore(allOpt, dropdown.firstChild);
	});

	document.getElementById("monthFilter").addEventListener("change", function () {
		const selected = this.value;
		const rows = document.querySelectorAll("tbody tr");

		rows.forEach(row => {
			const rowMonth = row.getAttribute("data-date");
			row.style.display = (selected === "all" || rowMonth === selected) ? "" : "none";
		});
	});
	</script>
</body>
</html>
