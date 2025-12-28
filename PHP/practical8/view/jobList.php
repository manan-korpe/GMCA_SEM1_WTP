<?php
require "../model/util/auth.php";
require "../model/util/db.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM job_application WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Responsive Table</title>
<link rel="stylesheet" href="../css/jobList.css">
    <link rel="stylesheet" href="../css/toast.css"/>
</head>

<body>
<h2>Applicants Table</h2>
<div class="right-buttons">
    <?php
    if ($result->num_rows > 0) {
        echo "<center><a href='../../practical2/form.php' class='edit-btn btn'>New Application</a></center>";
    }
?>
        <a href="../../practical1/index.php" class="delete-btn btn">Home</a>
</div>
<?php
    if ($result->num_rows > 0) {
?>
<table class="responsive-table">
    <thead>
        <tr>
            <th>Application ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Job</th>
            <th>Resume</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>

    <tbody id="dataRows">
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><span class="table-label">ID:</span> <button class="id-btn" onclick="showDetails(
                '<?= $row['id'] ?>',
                '<?= $row['fname'] ?>',
                '<?= $row['lname'] ?>',
                '<?= $row['dob'] ?>',
                '<?= $row['gender'] ?>',
                '<?= $row['marital'] ?>',
                '<?= $row['nationality'] ?>',
                '<?= $row['mobile'] ?>',
                '<?= $row['email'] ?>',
                `<?= addslashes($row['address']) ?>`,
                '<?= $row['pincode'] ?>',
                '<?= $row['qualification'] ?>',
                '<?= $row['fieldofstudy'] ?>',
                '<?= $row['universityinstitutionname'] ?>',
                '<?= $row['experience'] ?>',
                '<?= $row['experienceyear'] ?>',
                '<?= $row['previousjob'] ?>',
                '<?= $row['company'] ?>',
                '<?= $row['previoussalary'] ?>',
                '<?= $row['skills'] ?>',
                '<?= $row['jobposition'] ?>',
                '<?= $row['joblocation'] ?>',
                '<?= $row['startdate'] ?>',
                '<?= $row['jobexpectedsalary'] ?>',
                '../model/<?= $row['resume']; ?>',
                '../model/<?= $row['photo']; ?>'
            )"><?= $row['id']; ?></button></td>
            <td><span class="table-label">Image:</span> <img src="../model/<?= $row['photo']; ?>"></td>
            <td><span class="table-label">Name:</span> <?= $row['fname']." ".$row['lname']; ?></td>
            <td><span class="table-label">Email:</span> <?= $row['email']; ?></td>
            <td><span class="table-label">Job Applied:</span> <?= $row['jobposition']; ?></td>
            <td><span class="table-label">Resume:</span> <a href="../model/<?= $row['resume']; ?>" target="_blank">View</a></td>
            <td><span class="table-label">Edit:</span><a class="edit-btn btn"  href="edit_application.php?id=<?= $row['id']; ?>">
            Edit
            </a></td>
            <td><span class="table-label">Delete:</span> <a class="delete-btn btn" href="../model/delete_application.php?id=<?= $row['id']; ?>"  
            onclick="return confirm('Are you sure you want to delete this application?');">
            Delete
            </a></td>
        </tr>
        <?php
    }   
} else {
    echo "<div class='no-applications'>";
    echo "<center><p>No applications found.</p></center>";
    echo "<center><a href='../../practical2/form.php' class='edit-btn btn'>New Application</a></center>";
    echo "</div>";
}
?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal" id="detailModal">
    <div class="modal-content">
        
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Applicant Details</h2>

        <div class="modal-body">
            <!-- PERSONAL DETAILS -->
            <h3 class="section-title">Personal Details</h3>
            <div class="section-grid">
                <div><b>ID:</b> <span id="d_id"></span></div>
                <div><b>Name:</b> <span id="d_name"></span></div>
                <div><b>DOB:</b> <span id="d_dob"></span></div>
                <div><b>Gender:</b> <span id="d_gender"></span></div>
                <div><b>Marital Status:</b> <span id="d_marital"></span></div>
                <div><b>Nationality:</b> <span id="d_nationality"></span></div>
            </div>

            <!-- CONTACT DETAILS -->
            <h3 class="section-title">Contact Details</h3>
            <div class="section-grid">
                <div><b>Mobile:</b> <span id="d_mobile"></span></div>
                <div><b>Email:</b> <span id="d_email"></span></div>
                <div style="grid-column: span 2;"><b>Address:</b> <span id="d_address"></span></div>
                <div><b>Pincode:</b> <span id="d_pincode"></span></div>
            </div>

            <!-- EDUCATIONAL DETAILS -->
            <h3 class="section-title">Educational Details</h3>
            <div class="section-grid">
                <div><b>Qualification:</b> <span id="d_qualification"></span></div>
                <div><b>Field of Study:</b> <span id="d_field"></span></div>
                <div style="grid-column: span 2;"><b>University:</b> <span id="d_university"></span></div>
            </div>

            <!-- WORK EXPERIENCE -->
            <h3 class="section-title">Work Experience</h3>
            <div class="section-grid">
                <div><b>Experience:</b> <span id="d_experience"></span></div>
                <div><b>Experience Years:</b> <span id="d_experienceyear"></span></div>
                <div><b>Previous Job:</b> <span id="d_previousjob"></span></div>
                <div><b>Company:</b> <span id="d_company"></span></div>
                <div><b>Previous Salary:</b> <span id="d_previoussalary"></span></div>
                <div style="grid-column: span 2;"><b>Skills:</b> <span id="d_skills"></span></div>
            </div>

            <!-- JOB DETAILS -->
            <h3 class="section-title">Job-Related Details</h3>
            <div class="section-grid">
                <div><b>Applied Job:</b> <span id="d_jobposition"></span></div>
                <div><b>Location:</b> <span id="d_joblocation"></span></div>
                <div><b>Start Date:</b> <span id="d_startdate"></span></div>
                <div><b>Expected Salary:</b> <span id="d_expectedsalary"></span></div>
            </div>

            <!-- DOCUMENTS -->
            <h3 class="section-title">Upload Documents</h3>
            <div class="section-grid">
                <div>
                    <b>Resume:</b><br>
                    <a id="d_resume" target="_blank" class="btn-doc">Open Resume</a>
                </div>
                <div>
                    <b>Photo:</b><br>
                    <img id="d_photo" alt="Photo" class="photo-box">
                </div>
            </div>

        </div>
    </div>
</div>

    <?php
        require "../model/util/toast.php";
    ?>
<script>
// SAMPLE DATA
let applicants = [
    {
        id: 101,
        img: "https://via.placeholder.com/50",
        firstname: "John",
        lastname: "Doe",
        resume: "resume_john.pdf",
        job: "Web Developer",
        location: "New York"
    },
    {
        id: 102,
        img: "https://via.placeholder.com/50",
        firstname: "Anna",
        lastname: "Smith",
        resume: "resume_anna.pdf",
        job: "UI/UX Designer",
        location: "Los Angeles"
    }
];

// Load table dynamically
function loadTable() {
    let rows = "";
    applicants.forEach((a, index) => {
        rows += `
        <tr>
            <td><span class="table-label">ID:</span> <button class="id-btn" onclick="showDetails(${index})">${a.id}</button></td>
            <td><span class="table-label">Image:</span> <img src="${a.img}"></td>
            <td><span class="table-label">Name:</span> ${a.firstname} ${a.lastname}</td>
            <td><span class="table-label">Resume:</span> <a href="${a.resume}" target="_blank">View</a></td>
            <td><span class="table-label">Job:</span> ${a.job}</td>
            <td><span class="table-label">Location:</span> ${a.location}</td>
            <td><span class="table-label">Edit:</span> <button class="edit-btn" onclick="editItem(${index})">Edit</button></td>
            <td><span class="table-label">Delete:</span> <button class="delete-btn" onclick="deleteItem(${index})">Delete</button></td>
        </tr>`;
    });
    document.getElementById("dataRows").innerHTML = rows;
}

// loadTable();

// Show modal
function showDetails(
    id, fname, lname, dob, gender, marital, nationality,
    mobile, email, address, pincode, qualification, fieldofstudy,
    university, experience, experienceyear, previousjob, company,
    previoussalary, skills, jobposition, joblocation, startdate,
    expectedsalary, resume, photo
) {
    document.getElementById("d_id").innerText = id;
    document.getElementById("d_name").innerText = fname + " " + lname;
    document.getElementById("d_dob").innerText = dob;
    document.getElementById("d_gender").innerText = gender;
    document.getElementById("d_marital").innerText = marital;
    document.getElementById("d_nationality").innerText = nationality;
    document.getElementById("d_mobile").innerText = mobile;
    document.getElementById("d_email").innerText = email;
    document.getElementById("d_address").innerText = address;
    document.getElementById("d_pincode").innerText = pincode;
    document.getElementById("d_qualification").innerText = qualification;
    document.getElementById("d_field").innerText = fieldofstudy;
    document.getElementById("d_university").innerText = university;
    document.getElementById("d_experience").innerText = experience;
    document.getElementById("d_experienceyear").innerText = experienceyear;
    document.getElementById("d_previousjob").innerText = previousjob;
    document.getElementById("d_company").innerText = company;
    document.getElementById("d_previoussalary").innerText = previoussalary;
    document.getElementById("d_skills").innerText = skills;
    document.getElementById("d_jobposition").innerText = jobposition;
    document.getElementById("d_joblocation").innerText = joblocation;
    document.getElementById("d_startdate").innerText = startdate;
    document.getElementById("d_expectedsalary").innerText = expectedsalary;
    document.getElementById("d_resume").href = resume;
    document.getElementById("d_photo").src = photo;

    document.getElementById("detailModal").style.display = "flex";
}

// Close modal
function closeModal() {
    document.getElementById("detailModal").style.display = "none";
}

</script>

</body>
</html>

