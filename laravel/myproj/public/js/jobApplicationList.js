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