<?php
include 'db_connect.php'; // connect to DB

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id         = $_POST['user_id'];
    $full_name       = $_POST['full_name'];
    $email           = $_POST['email'];
    $department_head = $_POST['department_head'];
    $leave_type      = $_POST['leave_type'];
    $start_date      = $_POST['start_date'];
    $end_date        = $_POST['end_date'];
    $cash_conversion = $_POST['cash_conversion'];

    // Calculate total days (inclusive)
    $date1 = new DateTime($start_date);
    $date2 = new DateTime($end_date);
    $total_days = $date1->diff($date2)->days + 1;

    // Filing date = today
    $filing_date = date("Y-m-d");

    // Insert query
    $sql = "INSERT INTO leave_applications 
            (user_id, full_name, email, department_head, filing_date, leave_type, start_date, end_date, total_days, cash_conversion, hr_status, dept_head_status, gm_status, final_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Pending', 'Pending', 'Pending')";

    // Prepare & bind
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind (all strings except user_id which is int, and total_days which is int)
    $stmt->bind_param(
        "isssssssis",
        $user_id,        // i (int)
        $full_name,      // s (string)
        $email,          // s
        $department_head,// s
        $filing_date,    // s
        $leave_type,     // s
        $start_date,     // s
        $end_date,       // s
        $total_days,     // i
        $cash_conversion // s
    );

    if ($stmt->execute()) {
        echo "<script>alert('Leave application submitted successfully! Sent to HR for review.'); window.location.href='index.php';</script>";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
