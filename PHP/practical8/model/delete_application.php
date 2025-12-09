<?php
require "util/auth.php";
require "util/db.php";

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$app_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check if this application belongs to the logged-in user
$sql = "SELECT resume, photo FROM job_application WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $app_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Unauthorized action.");
}

$row = $result->fetch_assoc();

// Delete files
if (file_exists($row['resume'])) {
    unlink($row['resume']);
}
if (file_exists($row['photo'])) {
    unlink($row['photo']);
}

// Delete DB record
$del = $conn->prepare("DELETE FROM job_application WHERE id = ? AND user_id = ?");
$del->bind_param("ii", $app_id, $user_id);

if ($del->execute()) {
    $_SESSION["toastMessage"] = "Application Deleted successfuly!";
    $_SESSION["toastType"] = "success";
    echo "<script> window.location.href='../view/jobList.php';</script>";
} else {
    $_SESSION["toastMessage"] = "Error deleting application!";
    $_SESSION["toastType"] = "error";
    echo "Error deleting application";
}
?>
