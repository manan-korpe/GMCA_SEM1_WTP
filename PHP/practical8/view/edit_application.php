<?php
require "../model/util/auth.php";
require "../model/util/db.php";

if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$app_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM job_application WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $app_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION["toastMessage"] = "Unauthorized to perform action!";
    $_SESSION["toastType"] = "error";
    die("Unauthorized access.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>

    <link rel="stylesheet" href="../../practical3/form.css" />
    <link rel="stylesheet" href="../../practical4/responsiveForm.css" />
    <link rel="stylesheet" href="../css/toast.css"/>
    <script src="../../practical7/validation.js"></script>
    <script src="../../practical6/events.js"></script>
</head>

<body>

<form id="applicationForm" action="../model/update_application.php" method="POST" enctype="multipart/form-data">
    <h2 class="title">Edit Job Application</h2>

    <input type="hidden" name="id" value="<?= $row['id']; ?>">

    <!-- PERSONAL DETAILS -->
    <fieldset>
        <legend class="sub-title">Personal Details</legend>

        <div>
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" value="<?= $row['fname']; ?>"
                   onkeypress="handleKeyPress(event)" onkeydown="handleKeyDown(event)">
            <div class="error" id="fname-error"></div>
        </div>

        <div>
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" value="<?= $row['lname']; ?>"
                   onkeypress="handleKeyPress(event)" onkeydown="handleKeyDown(event)">
            <div class="error" id="lname-error"></div>
        </div>

        <div>
            <label for="dob">DOB</label>
            <input type="date" id="dob" name="dob" value="<?= $row['dob']; ?>">
            <div class="error" id="dob-error"></div>
        </div>

        <div>
            <span>Gender</span>
            <label><input type="radio" name="gender" value="male" <?= $row['gender']=="male"?"checked":"" ?>>Male</label>
            <label><input type="radio" name="gender" value="female" <?= $row['gender']=="female"?"checked":"" ?>>Female</label>
            <div class="error" id="gender-error"></div>
        </div>

        <div>
            <span>Marital Status</span>
            <label><input type="radio" name="marital" value="married" <?= $row['marital']=="married"?"checked":"" ?>>Married</label>
            <label><input type="radio" name="marital" value="Unmarried" <?= $row['marital']=="Unmarried"?"checked":"" ?>>Unmarried</label>
            <div class="error" id="marital-error"></div>
        </div>

        <div>
            <label for="nationality">Nationality</label>
            <select id="nationality" name="nationality">
                <option disabled value="">Nationality</option>
                <option value="india" <?= $row['nationality']=="india"?"selected":"" ?>>India</option>
                <option value="USA" <?= $row['nationality']=="USA"?"selected":"" ?>>USA</option>
            </select>
            <div class="error" id="nationality-error"></div>
        </div>
    </fieldset>

    <!-- CONTACT DETAILS -->
    <fieldset>
        <legend class="sub-title">Contact Details</legend>

        <div>
            <label for="mobile">Mobile No</label>
            <input type="text" id="mobile" name="mobile" value="<?= $row['mobile']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)">
            <div class="error" id="mobile-error"></div>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= $row['email']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)">
            <div class="error" id="email-error"></div>
        </div>

        <div>
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="5"
                      onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)"
                      onkeypress="handleKeyPress(event)" onkeydown="handleKeyDown(event)"><?= $row['address']; ?></textarea>
            <div class="error" id="address-error"></div>
        </div>

        <div>
            <label for="pincode">Pin Code</label>
            <input type="text" id="pincode" name="pincode" value="<?= $row['pincode']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)">
            <div class="error" id="pincode-error"></div>
        </div>
    </fieldset>

    <!-- EDUCATIONAL DETAILS -->
    <fieldset>
        <legend class="sub-title">Educational Details</legend>

        <div>
            <label for="qualification">Select qualification</label>
            <select id="qualification" name="qualification">
                <option disabled value="">Education</option>
                <option value="10" <?= $row['qualification']=="10"?"selected":"" ?>>10th passed</option>
                <option value="12" <?= $row['qualification']=="12"?"selected":"" ?>>12th Passed</option>
                <option value="graduation" <?= $row['qualification']=="graduation"?"selected":"" ?>>Graduation</option>
                <option value="postGraduation" <?= $row['qualification']=="postGraduation"?"selected":"" ?>>Post-Graduation</option>
            </select>
            <div class="error" id="qualification-error"></div>
        </div>

        <div>
            <span>Field Of Study </span>
            <label><input type="radio" name="fieldofstudy" value="arts" <?= $row['fieldofstudy']=="arts"?"checked":"" ?>>Arts </label>
            <label><input type="radio" name="fieldofstudy" value="commerce" <?= $row['fieldofstudy']=="commerce"?"checked":"" ?>>Commerce</label>
            <label><input type="radio" name="fieldofstudy" value="science" <?= $row['fieldofstudy']=="science"?"checked":"" ?>>Science</label>
            <div class="error" id="fieldofstudy-error"></div>
        </div>

        <div>
            <label for="university-institution-name">University/Institution Name</label>
            <input type="text" id="university-institution-name" name="universityinstitutionname"
                   value="<?= $row['universityinstitutionname']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)"
                   onkeypress="handleKeyPress(event)" onkeydown="handleKeyDown(event)">
            <div class="error" id="universityinstitutionname-error"></div>
        </div>
    </fieldset>

    <!-- WORK EXPERIENCE -->
    <fieldset>
        <legend class="sub-title">Work Experience</legend>
        <input type="hidden" id="ExperienceOpen" value="false"/>
        <div>
            <input type="radio" name="experience" value="fresher" id="fresher" <?= $row['experience']=="fresher"?"checked":"" ?>> Fresher
            <input type="radio" name="experience" value="experienced" id="experienced" <?= $row['experience']=="experienced"?"checked":"" ?>> Experienced
        </div>
        <div class="error" id="experience-error"></div>
         <div class="hidden-experience" id="hidden-experience" <?= $row['experience']=="fresher"?"style=display:none":"style=display:block" ?>>
        <div>
            <label>Work Experience in Year</label>
            <input type="number" name="experienceyear" id="job-experience-year"
                   value="<?= $row['experienceyear']; ?>">
            <div class="error" id="experienceyear-error"></div>
        </div>

        <div>
            <label>Previous Job Titles </label>
            <input type="text" id="job-previous" name="previousjob"
                   value="<?= $row['previousjob']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)">
            <div class="error" id="previousjob-error"></div>
        </div>

        <div>
            <label>Previous Company Name </label>
            <input type="text" id="job-company" name="company"
                   value="<?= $row['company']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)">
            <div class="error" id="company-error"></div>
        </div>

        <div>
            <label>Previous Salary </label>
            <input type="text" id="job-previous-salary" name="previoussalary"
                   value="<?= $row['previoussalary']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)">
            <div class="error" id="previoussalary-error"></div>
        </div>

        <div class="multi-value">
            <span>Relevant Skill</span>
            <?php $skillArray = explode(",", $row['skills']); ?>

            <label><input type="checkbox" name="skill[]" value="communication" <?= in_array("communication",$skillArray)?"checked":"" ?>>Communication</label>

            <label><input type="checkbox" name="skill[]" value="problemsolving" <?= in_array("problemsolving",$skillArray)?"checked":"" ?>>Problem Solving</label>

            <label><input type="checkbox" name="skill[]" value="leadership" <?= in_array("leadership",$skillArray)?"checked":"" ?>>Leadership</label>

            <label><input type="checkbox" name="skill[]" value="timemanagement" <?= in_array("timemanagement",$skillArray)?"checked":"" ?>>Time Management</label>

            <label><input type="checkbox" name="skill[]" value="dataanalysis" <?= in_array("dataanalysis",$skillArray)?"checked":"" ?>>Data Analysis</label>

            <label><input type="checkbox" name="skill[]" value="customerservice" <?= in_array("customerservice",$skillArray)?"checked":"" ?>>Customer Service</label>

            <div class="error" id="skill-error"></div>
        </div>
</div>
    </fieldset>

    <!-- JOB DETAILS -->
    <fieldset>
        <legend class="sub-title">Job Details</legend>

        <div>
            <label for="job-position">Position Applying For</label>
            <select id="job-position" name="jobposition"
                    onmouseover="showMenu(this)" onmouseout="hideMenu(this)">
                <option disabled value="">Position</option>
                <option value="preojectmanager" <?= $row['jobposition']=="preojectmanager"?"selected":"" ?>>Project Manager</option>
                <option value="businessanalyst" <?= $row['jobposition']=="businessanalyst"?"selected":"" ?>>Business Analyst</option>
                <option value="marketingmanager" <?= $row['jobposition']=="marketingmanager"?"selected":"" ?>>Marketing Manager</option>
                <option value="seniordeveloper" <?= $row['jobposition']=="seniordeveloper"?"selected":"" ?>>Senior Developer</option>
            </select>
            <div class="error" id="jobposition-error"></div>
        </div>

        <div>
            <label for="job-location">Preferred Location</label>
            <select id="job-location" name="joblocation">
                <option disabled value="">Location</option>
                <option value="ahmedabad" <?= $row['joblocation']=="ahmedabad"?"selected":"" ?>>Ahmedabad</option>
                <option value="pune" <?= $row['joblocation']=="pune"?"selected":"" ?>>Pune</option>
                <option value="delhi" <?= $row['joblocation']=="delhi"?"selected":"" ?>>Delhi</option>
                <option value="mumbai" <?= $row['joblocation']=="mumbai"?"selected":"" ?>>Mumbai</option>
            </select>
            <div class="error" id="joblocation-error"></div>
        </div>

        <div>
            <label for="start-date">Available Start Date</label>
            <input type="date" id="start-date" name="startdate" value="<?= $row['startdate']; ?>">
            <div class="error" id="startdate-error"></div>
        </div>

        <div>
            <label for="job-expected-salary">Expected Salary</label>
            <input type="text" id="job-expected-salary" name="jobexpectedsalary"
                   value="<?= $row['jobexpectedsalary']; ?>"
                   onfocus="handleFormFocus(this)" onblur="handleFormBlur(this)">
            <div class="error" id="jobexpectedsalary-error"></div>
        </div>

    </fieldset>

    <!-- UPLOAD DOCUMENTS -->
    <fieldset>
        <legend class="sub-title">Upload Documents</legend>

        <div>
        <label>Current Resume</label><br>
        <a href="../model/<?= $row['resume']; ?>" target="_blank">View Current Resume</a><br><br>

        <label>Upload new Resume (optional):</label>
        <input type="file"  id="resume" name="resume" accept=".pdf">
        <input type="hidden" name="old_resume" id="old_resume" value="<?= $row['resume']; ?>">
        <div class="error" id="resume-error"></div>
        </div>

        <div>
            <label>Current Photo</label><br>
            <img src="../model/<?= $row['photo']; ?>" width="120"><br><br>

            <label>Upload new Photo (optional):</label>
            <input type="file" id="photo" name="photo" accept="image/*">
            <input type="hidden" name="old_photo" id="old_photo" value="<?= $row['photo']; ?>">
            <div class="error" id="photo-error"></div>
        </div>
    </fieldset>

    <div class="btn-handler">
        <div>
            <input type="submit" value="Update" class="success-button">
            <a href="jobList.php" class="danger-button" style="text-decoration:none;padding:8px 20px;">Cancel</a>
            
        </div>
    </div>

</form>
    <?php 
        require "../model/util/toast.php";
    ?>
</body>
</html>
