<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // HR approves, forward to Dept Head
    $stmt = $conn->prepare("UPDATE leave_applications 
                            SET hr_status='Approved', dept_head_status='Pending' 
                            WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Leave request approved and sent to Department Head!'); 
              window.location.href='hr_pending.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
