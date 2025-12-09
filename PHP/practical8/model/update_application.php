<?php
require "util/auth.php";
require "util/db.php";

if (!isset($_POST['id'])) {
    $_SESSION["toastMessage"] = "Something Want Wrong!";
    $_SESSION["toastType"] = "error";
    die("Invalid request.");
}

$app_id = $_POST['id'];
$user_id = $_SESSION['user_id'];

// Fetch existing application (to keep old files)
$sql = "SELECT * FROM job_application WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $app_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    $_SESSION["toastMessage"] = "Unauthorized to perform action!";
    $_SESSION["toastType"] = "error";
    die("Unauthorized to perform action.");
}

$oldData = $res->fetch_assoc();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$marital = $_POST['marital'];
$nationality = $_POST['nationality'];

$mobile = $_POST['mobile'];
$email = $_POST['email'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];

$qualification = $_POST['qualification'];
$fieldofstudy = $_POST['fieldofstudy'];
$universityinstitutionname = $_POST['universityinstitutionname'];

$experience = $_POST['experience'];
$experienceyear = $_POST['experienceyear'] ?? NULL;
$previousjob = $_POST['previousjob'] ?? NULL;
$company = $_POST['company'] ?? NULL;
$previoussalary = $_POST['previoussalary'] ?? NULL;

// Skills
if (isset($_POST['skill'])) {
    $skills = implode(",", $_POST['skill']);
} else {
    $skills = NULL;
}

$jobposition = $_POST['jobposition'];
$joblocation = $_POST['joblocation'];
$startdate = $_POST['startdate'];
$jobexpectedsalary = $_POST['jobexpectedsalary'];


// File upload settings
$uploadDir = "uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Resume (check if new file uploaded)
if (!empty($_FILES["resume"]["name"])) {
    $resumeFile = $uploadDir . time() .$_POST['fname']. "_resume_" . basename($_FILES["resume"]["name"]);
    move_uploaded_file($_FILES["resume"]["tmp_name"], $resumeFile);
} else {
    $resumeFile = $_POST['old_resume'];  // keep old
}

// Photo (check if new file uploaded)
if (!empty($_FILES["photo"]["name"])) {
    $photoFile = $uploadDir . time() .$_POST['fname']. "_photo_" . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $photoFile);
} else {
    $photoFile = $_POST['old_photo']; // keep old
}

$sql = "UPDATE job_application SET
        fname = ?, lname = ?, dob = ?, gender = ?, marital = ?, nationality = ?,
        mobile = ?, email = ?, address = ?, pincode = ?,
        qualification = ?, fieldofstudy = ?, universityinstitutionname = ?,
        experience = ?, experienceyear = ?, previousjob = ?, company = ?, previoussalary = ?, skills = ?,
        jobposition = ?, joblocation = ?, startdate = ?, jobexpectedsalary = ?,
        resume = ?, photo = ?
        WHERE id = ? AND user_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssssssssssssssssssssssssii",
    $fname, $lname, $dob, $gender, $marital, $nationality,
    $mobile, $email, $address, $pincode,
    $qualification, $fieldofstudy, $universityinstitutionname,
    $experience, $experienceyear, $previousjob, $company, $previoussalary, $skills,
    $jobposition, $joblocation, $startdate, $jobexpectedsalary,
    $resumeFile, $photoFile,
    $app_id, $user_id
);

if ($stmt->execute()) {
    $_SESSION["toastMessage"] = "Job Application updated successfuly!";
    $_SESSION["toastType"] = "success";
    header("Location: ../view/jobList.php");
} else {
    $_SESSION["toastMessage"] = "Update record failed!";
    $_SESSION["toastType"] = "error";
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
exit;
?>
