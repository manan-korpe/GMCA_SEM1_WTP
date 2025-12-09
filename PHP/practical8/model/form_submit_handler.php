<?php
session_start();
require "./util/db.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION["toastMessage"] = "User is not logged in!";
    $_SESSION["toastType"] = "error";
    die("User is not logged in.");
}

$user_id = $_SESSION['user_id'];

// Collect Form Data
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

$experience = $_POST['experience'] ?? 'fresher';
$experienceyear = $_POST['experienceyear'] ?? NULL;
$previousjob = $_POST['previousjob'] ?? NULL;
$company = $_POST['company'] ?? NULL;
$previoussalary = $_POST['previoussalary'] ?? NULL;

// Skills (checkbox)
if (isset($_POST['skill'])) {
    if (is_array($_POST['skill'])) {
        $skills = implode(",", $_POST['skill']);
    } else {
        $skills = $_POST['skill']; 
    }
} else {
    $skills = NULL;
}


$jobposition = $_POST['jobposition'];
$joblocation = $_POST['joblocation'];
$startdate = $_POST['startdate'];
$jobexpectedsalary = $_POST['jobexpectedsalary'];

// File Upload
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Resume
$resumeFile = $uploadDir . time() .$_POST['fname']. "_resume_" . basename($_FILES["resume"]["name"]);
move_uploaded_file($_FILES["resume"]["tmp_name"], $resumeFile);

// Photo
$photoFile = $uploadDir . time() .$_POST['fname']. "_photo_" . basename($_FILES["photo"]["name"]);
move_uploaded_file($_FILES["photo"]["tmp_name"], $photoFile);

// SQL Insert
$sql = "INSERT INTO job_application (
            user_id, fname, lname, dob, gender, marital, nationality,
            mobile, email, address, pincode,
            qualification, fieldofstudy, universityinstitutionname,
            experience, experienceyear, previousjob, company, previoussalary, skills,
            jobposition, joblocation, startdate, jobexpectedsalary,
            resume, photo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepared Statement
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

if ($stmt->execute()) {
    $_SESSION["toastMessage"] = "Application successful submited!";
    $_SESSION["toastType"] = "success";
    echo "<script>window.location.href='../view/jobList.php';</script>";
} else {
    $_SESSION["toastMessage"] = "Application faild to submit try again!";
    $_SESSION["toastType"] = "success";
    echo "Error: " . $stmt->error;
    echo "<script>window.location.href='../../practical2/form.php';</script>";
}

$stmt->close();
$conn->close();
exit;
?>
