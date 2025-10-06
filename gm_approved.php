<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $leave_id = $_GET['id'];

    // Step 1: Fetch leave info
    $query = $conn->prepare("SELECT user_id, leave_type, total_days FROM leave_applications WHERE id = ?");
    $query->bind_param("i", $leave_id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    $user_id = $result['user_id'];
    $leave_type = $result['leave_type'];
    $days_used = $result['total_days'];
    $year = date('Y');

    // Step 2: Mark as approved
    $update = $conn->prepare("UPDATE leave_applications 
                              SET gm_status='Approved', final_status='Approved' 
                              WHERE id=?");
    $update->bind_param("i", $leave_id);
    $update->execute();

    // Step 3: Deduct from leave_credits
    if ($leave_type == 'Annual Leave') {
        $conn->query("UPDATE leave_credits SET used_annual = used_annual + $days_used WHERE user_id=$user_id AND year=$year");
    } elseif ($leave_type == 'Sick Leave') {
        $conn->query("UPDATE leave_credits SET used_sick = used_sick + $days_used WHERE user_id=$user_id AND year=$year");
    } elseif ($leave_type == 'Calamity Leave') {
        $conn->query("UPDATE leave_credits SET used_calamity = used_calamity + $days_used WHERE user_id=$user_id AND year=$year");
    }

    echo "<script>alert('Leave approved and deducted from remaining leave.'); window.location.href='gm_dashboard.php';</script>";
}
?>
