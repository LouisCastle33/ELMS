<?php
session_start();
include 'db_connect.php';

// Check if logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
	header("Location: register.php");
	exit;
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

// Fetch employee info from users table
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_data = $user_query->get_result()->fetch_assoc();

// Fetch leave counts for this employee
$hr_count = $conn->query("SELECT COUNT(*) as c FROM leave_applications WHERE user_id='$user_id' AND hr_status='Pending'")->fetch_assoc()['c'];
$dept_count = $conn->query("SELECT COUNT(*) as c FROM leave_applications WHERE user_id='$user_id' AND hr_status='Approved' AND dept_head_status='Pending'")->fetch_assoc()['c'];
$gm_count = $conn->query("SELECT COUNT(*) as c FROM leave_applications WHERE user_id='$user_id' AND dept_head_status='Approved' AND gm_status='Pending'")->fetch_assoc()['c'];

// Fetch remaining leave from leave_credits
$year = date('Y');
$leave_query = $conn->prepare("
    SELECT 
        (annual_leave - used_annual) +
        (sick_leave - used_sick) +
        (calamity_leave - used_calamity) AS remaining_leave
    FROM leave_credits 
    WHERE user_id = ? AND year = ?");
$leave_query->bind_param("ii", $user_id, $year);
$leave_query->execute();
$leave_result = $leave_query->get_result()->fetch_assoc();
$remaining_leave = $leave_result ? $leave_result['remaining_leave'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css" />
	<title>Employee Dashboard</title>
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
		<a href="#" class="nav-link">Welcome, <?= htmlspecialchars($name) ?>!</a>
	</nav>

	<main>
		<div class="head-title">
			<div class="left">
				<h1>Your Dashboard</h1>
				<p>Manage your leave applications here.</p>
			</div>
		</div>

		<div style="margin: 20px 0;">
			<a href="#" class="apply-btn" id="openModalBtn">
				<i class='bx bx-calendar-plus'></i>
				Apply for Leave
			</a>
		</div>

		<!-- Summary -->
		<ul class="box-info">
			<li>
				<i class='bx bxs-user-check'></i>
				<span class="text"><h3><?= $hr_count ?></h3><p>Under HR Review</p></span>
			</li>
			<li>
				<i class='bx bxs-briefcase'></i>
				<span class="text"><h3><?= $dept_count ?></h3><p>At Dept Head</p></span>
			</li>
			<li>
				<i class='bx bxs-building'></i>
				<span class="text"><h3><?= $gm_count ?></h3><p>At Gen Manager</p></span>
			</li>
			<li>
				<i class='bx bxs-wallet'></i>
				<span class="text"><h3><?= $remaining_leave ?></h3><p>Remaining Leave</p></span>
			</li>
		</ul>

		<!-- Recent Leave Applications -->
		<div class="table-data">
			<div class="order">
				<div class="head"><h3>Your Recent Leave Applications</h3></div>
				<table>
					<thead>
						<tr>
							<th>Date Filed</th>
							<th>Type</th>
							<th>HR Status</th>
							<th>Dept Head</th>
							<th>Gen Manager</th>
							<th>Overall</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$res = $conn->query("SELECT * FROM leave_applications WHERE user_id='$user_id' ORDER BY filing_date DESC LIMIT 10");
						if ($res->num_rows > 0) {
							while ($row = $res->fetch_assoc()) {
								echo "<tr>
									<td>".date("F j, Y", strtotime($row['filing_date']))."</td>
									<td>".$row['leave_type']."</td>
									<td><span class='status ".strtolower($row['hr_status'])."'>".$row['hr_status']."</span></td>
									<td><span class='status ".strtolower($row['dept_head_status'])."'>".$row['dept_head_status']."</span></td>
									<td><span class='status ".strtolower($row['gm_status'])."'>".$row['gm_status']."</span></td>
									<td><span class='status ".strtolower($row['final_status'])."'>".$row['final_status']."</span></td>
								</tr>";
							}
						} else {
							echo "<tr><td colspan='6' style='text-align:center;'>No leave applications found.</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
</section>

<!-- MODAL FORM -->
<div id="leaveModal" class="modal">
  <div class="modal-content">
    <div class="modal-form-card">
      <span class="close">&times;</span>
      <h3>Leave Application Form</h3>

      <form action="submit_leave.php" method="POST">
        <h4>Employee Information</h4>
        <div class="form-row">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($user_data['name']) ?>" readonly>
          </div>
          <div class="form-group">
            <label>Employee ID</label>
            <input type="text" name="user_id" value="<?= $user_id ?>" readonly>
          </div>
        </div>
        <div class="form-group full">
          <label>Email Address</label>
          <input type="email" name="email" value="<?= htmlspecialchars($user_data['email']) ?>" readonly>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Department</label>
            <select name="department_head" required>
              <option value="">Select department</option>
              <option value="HR">HR</option>
              <option value="IT">IT</option>
              <option value="Finance">Finance</option>
            </select>
          </div>
          <div class="form-group">
            <label>Position</label>
            <input type="text" name="position">
          </div>
        </div>

        <h4>Leave Details</h4>
        <div class="form-group full">
          <label>Leave Type</label>
          <select name="leave_type" required>
            <option value="Annual Leave">Annual Leave</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Calamity Leave">Calamity Leave</option>
          </select>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date" required>
          </div>
          <div class="form-group">
            <label>End Date</label>
            <input type="date" name="end_date" required>
          </div>
          <div class="form-group">
            <label>Total Days</label>
            <input type="number" name="total_days" readonly>
          </div>
        </div>
        <div class="form-group full">
          <label>Turn to Cash?</label>
          <select name="cash_conversion" required>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </div>
        <button type="submit" class="submit-btn">Submit Application</button>
      </form>
    </div>

    <!-- Workflow -->
    <div class="workflow-panel">
      <h4><i class="bx bx-time"></i> Approval Workflow</h4>
      <ul class="workflow-list">
        <li><div class="wf-step step1">1</div><div><strong>HR Review</strong><p>Initial application review</p></div></li>
        <li><div class="wf-step step2">2</div><div><strong>Department Head</strong><p>Department approval</p></div></li>
        <li><div class="wf-step step3">3</div><div><strong>General Manager</strong><p>Final approval</p></div></li>
        <li><div class="wf-step step4">4</div><div><strong>Payroll Processing</strong><p>Leave processing</p></div></li>
      </ul>
    </div>
  </div>
</div>

</body>
</html>



<script>
// Auto-calc total days
document.querySelector('input[name="start_date"]').addEventListener('change', calcDays);
document.querySelector('input[name="end_date"]').addEventListener('change', calcDays);

function calcDays() {
  let start = document.querySelector('input[name="start_date"]').value;
  let end = document.querySelector('input[name="end_date"]').value;
  if (start && end) {
    let s = new Date(start);
    let e = new Date(end);
    let diff = Math.floor((e - s) / (1000 * 60 * 60 * 24)) + 1;
    if (diff > 0) {
      document.querySelector('input[name="total_days"]').value = diff;
    }
  }
}
</script>


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
