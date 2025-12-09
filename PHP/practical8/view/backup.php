<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Job Applications</title>
    <link rel="stylesheet" href="../css/application.css">
        <link rel="stylesheet" href="../css/toast.css"/>
</head>
<body>
<div class="title-bar">
    <h2 class="title">Your Job Applications</h2>

    <div class="right-buttons">
        <a href="../../practical2/form.php" class="new-btn">New Application</a>
        <a href="../../practical1/index.php" class="home-btn">Home</a>
    </div>
</div>


<div class="cards-container">

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

    <div class="card">
        <div class="card-header">
    <h3 class="card-title">Application ID:<?= $row['id']; ?></h3>
    <div class="action-buttons">
        <a href="edit_application.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
        <a href="../model/delete_application.php?id=<?= $row['id']; ?>" 
           class="delete-btn" 
           onclick="return confirm('Are you sure you want to delete this application?');">
           Delete
        </a>
    </div>
</div>


        <div class="card-body">
            <p><strong>Name:</strong> <?= $row['fname'] . " " . $row['lname']; ?></p>
            <p><strong>DOB:</strong> <?= $row['dob']; ?></p>
            <p><strong>Gender:</strong> <?= $row['gender']; ?></p>
            <p><strong>Mobile:</strong> <?= $row['mobile']; ?></p>
            <p><strong>Email:</strong> <?= $row['email']; ?></p>
            <p><strong>Qualification:</strong> <?= $row['qualification']; ?></p>
            <p><strong>Skills:</strong> <?= $row['skills']; ?></p>
            <p><strong>Job Position:</strong> <?= $row['jobposition']; ?></p>
            <p><strong>Expected Salary:</strong> <?= $row['jobexpectedsalary']; ?></p>

            <p><strong>Resume:</strong> <a href="../model/<?= $row['resume']; ?>" target="_blank">Download</a></p>

            <p><strong>Photo:</strong></p>
            <img src="../model/<?= $row['photo']; ?>" class="user-photo">
        </div>
    </div>

<?php
    }
} else {
    echo "<div class='no-applications'>";
    echo "<p>No applications found.</p>";
    echo "<a href='../../practical2/form.php' class='create-btn'>Create New Application</a>";
    echo "</div>";
}
?>

    <?php
        require "../model/util/toast.php";
    ?>
</div>

</body>
</html> -->

