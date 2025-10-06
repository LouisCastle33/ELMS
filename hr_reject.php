<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // HR rejects, mark as final rejected
    $stmt = $conn->prepare("UPDATE leave_applications 
                            SET hr_status='Rejected', final_status='Rejected' 
                            WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Leave request rejected.'); 
              window.location.href='hr_pending.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
