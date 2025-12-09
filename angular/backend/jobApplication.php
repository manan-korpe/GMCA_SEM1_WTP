<?php
header("Content-Type: application/json");
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type");
session_start();
require "./util/db.php";

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Token/Auth Example (Optional)
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(["status" => "error", "message" => "User ID is required"]);
    exit;
}

// Collect Inputs (POST + FILES)
$fname = $_POST['fname'];
$lname = $_POST['lname'] ?? null;
$dob = $_POST['dob'] ?? null;
$gender = $_POST['gender'] ?? null;
$marital = $_POST['marital'] ?? null;
$nationality = $_POST['nationality'] ?? null;

$mobile = $_POST['mobile'] ?? null;
$email = $_POST['email'] ?? null;
$address = $_POST['address'] ?? null;
$pincode = $_POST['pincode'] ?? null;

$qualification = $_POST['qualification'] ?? null;
$fieldofstudy = $_POST['fieldofstudy'] ?? null;
$universityinstitutionname = $_POST['universityinstitutionname'] ?? null;

$experience = $_POST['experience'] ?? 'fresher';
$experienceyear = $_POST['experienceyear'] ?? null;
$previousjob = $_POST['previousjob'] ?? null;
$company = $_POST['company'] ?? null;
$previoussalary = $_POST['previoussalary'] ?? null;

// Skills from checkbox array
$skills = isset($_POST['skill'])
    ? (is_array($_POST['skill']) ? implode(",", $_POST['skill']) : $_POST['skill'])
    : null;

$jobposition = $_POST['jobposition'] ?? null;
$joblocation = $_POST['joblocation'] ?? null;
$startdate = $_POST['startdate'] ?? null;
$jobexpectedsalary = $_POST['jobexpectedsalary'] ?? null;

// File Upload Handling
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$resumeFile = null;
$photoFile = null;

if (isset($_FILES["resume"])) {
    $resumeFile = $uploadDir . time() . "_resume_" . basename($_FILES["resume"]["name"]);
    move_uploaded_file($_FILES["resume"]["tmp_name"], $resumeFile);
}

if (isset($_FILES["photo"])) {
    $photoFile = $uploadDir . time() . "_photo_" . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $photoFile);
}

// SQL Insert
$sql = "INSERT INTO job_application (
            user_id, fname, lname, dob, gender, marital, nationality,
            mobile, email, address, pincode,
            qualification, fieldofstudy, universityinstitutionname,
            experience, experienceyear, previousjob, company, previoussalary, skills,
            jobposition, joblocation, startdate, jobexpectedsalary,
            resume, photo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "isssssssssssssssssssssssss",
    $user_id,
    $fname, $lname, $dob, $gender, $marital, $nationality,
    $mobile, $email, $address, $pincode,
    $qualification, $fieldofstudy, $universityinstitutionname,
    $experience, $experienceyear, $previousjob, $company, $previoussalary, $skills,
    $jobposition, $joblocation, $startdate, $jobexpectedsalary,
    $resumeFile, $photoFile
);

// Execute
if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Application submitted successfully!"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to submit application",
        "error" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
exit;
?>
