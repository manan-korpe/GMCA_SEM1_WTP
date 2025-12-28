<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
    <link rel="stylesheet" href="../css/jobApplication.css" />
    <script src="../js/jobApplication.js"></script>
</head>

<body>
<form id="applicationForm" onsubmit="handleForm(this)" action='{{ route('jobApplication.up',['id'=>$application->id]) }}' method="post" enctype="multipart/form-data">
    @csrf    
    <h2 class="title">Job Application Form</h2>

    <!-- Personal Details -->
    <fieldset>
        <legend class="sub-title">Personal Details</legend>

        <div>
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" placeholder="First name" value="{{ $application->fname }}" />
            <div class="error" id="fname-error"></div>
        </div>

        <div>
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" placeholder="Last name" value="{{ $application->lname }}" />
            <div class="error" id="lname-error"></div>
        </div>

        <div>
            <label for="dob">DOB</label>
            <input type="date" id="dob" name="dob" max="2025-09-26" value="{{ $application->dob }}" />
            <div class="error" id="dob-error"></div>
        </div>

        <div>
            <span>Gender</span>
            <label><input type="radio" name="gender" value="male" {{ $application->gender == 'male' ? 'checked' : '' }}> Male</label>
            <label><input type="radio" name="gender" value="female" {{ $application->gender == 'female' ? 'checked' : '' }}> Female</label>
            <div class="error" id="gender-error"></div>
        </div>

        <div>
            <span>Marital Status</span>
            <label><input type="radio" name="marital" value="married" {{ $application->marital == 'married' ? 'checked' : '' }}> Married</label>
            <label><input type="radio" name="marital" value="Unmarried" {{ $application->marital == 'Unmarried' ? 'checked' : '' }}> Unmarried</label>
            <div class="error" id="marital-error"></div>
        </div>

        <div>
            <label for="nationality">Nationality</label>
            <select id="nationality" name="nationality">
                <option disabled value="">Nationality</option>
                <option value="india" {{ $application->nationality == 'india' ? 'selected' : '' }}>India</option>
                <option value="USA" {{ $application->nationality == 'USA' ? 'selected' : '' }}>USA</option>
            </select>
            <div class="error" id="nationality-error"></div>
        </div>
    </fieldset>

    <!-- Contact Details -->
    <fieldset>
        <legend class="sub-title">Contact Details</legend>

        <div>
            <label for="mobile">Mobile No</label>
            <input type="text" id="mobile" name="mobile" placeholder="Mobile number" value="{{ $application->mobile }}" />
            <div class="error" id="mobile-error"></div>
        </div>

        <div>
            <label for="email">Email id</label>
            <input type="email" id="email" name="email" placeholder="Email" value="{{ $application->email }}" />
            <div class="error" id="email-error"></div>
        </div>

        <div>
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="5" cols="40">{{ $application->address }}</textarea>
            <div class="error" id="address-error"></div>
        </div>

        <div>
            <label for="pincode">Pin Code</label>
            <input type="text" name="pincode" id="pincode" value="{{ $application->pincode }}" />
            <div class="error" id="pincode-error"></div>
        </div>
    </fieldset>

    <!-- Educational Details -->
    <fieldset>
        <legend class="sub-title">Educational Details</legend>

        <div>
            <label for="qualification">Select qualification</label>
            <select id="qualification" name="qualification">
                <option disabled value="">Education</option>
                <option value="10" {{ $application->qualification == '10' ? 'selected' : '' }}>10th passed</option>
                <option value="12" {{ $application->qualification == '12' ? 'selected' : '' }}>12th Passed</option>
                <option value="graduation" {{ $application->qualification == 'graduation' ? 'selected' : '' }}>Graduation</option>
                <option value="postGraduation" {{ $application->qualification == 'postGraduation' ? 'selected' : '' }}>Post-Graduation</option>
            </select>
            <div class="error" id="qualification-error"></div>
        </div>

        <div>
            <span>Field Of Study</span>
            <label><input type="radio" name="fieldofstudy" value="arts" {{ $application->fieldofstudy == 'arts' ? 'checked' : '' }}> Arts</label>
            <label><input type="radio" name="fieldofstudy" value="commerce" {{ $application->fieldofstudy == 'commerce' ? 'checked' : '' }}> Commerce</label>
            <label><input type="radio" name="fieldofstudy" value="science" {{ $application->fieldofstudy == 'science' ? 'checked' : '' }}> Science</label>
            <div class="error" id="fieldofstudy-error"></div>
        </div>

        <div>
            <label for="university-institution-name">University/Institution Name</label>
            <input type="text" name="universityinstitutionname" id="university-institution-name" value="{{ $application->universityinstitutionname }}" />
            <div class="error" id="universityinstitutionname-error"></div>
        </div>
    </fieldset>

    <!-- Work Experience -->
    <fieldset>
        <legend class="sub-title" >Work Experience</legend>
        <input type="hidden" id="ExperienceOpen" value="{{ $application->experience == 'experienced' ? 'true' : 'false' }}"/>
        <div>
            <input type="radio" name="experience" value="fresher" id="fresher" {{ $application->experience == 'fresher' ? 'checked' : '' }}> Fresher
            <input type="radio" name="experience" value="experienced" id="experienced" {{ $application->experience == 'experienced' ? 'checked' : '' }}> Experienced
        </div>
        <div class="error" id="experience-error"></div>

        <div class="hidden-experience" id="hidden-experience" style="{{ $application->experience == 'experienced' ? 'display:block;' : 'display:none;' }}">
            <div>
                <label for="job-experience-year">Work Experience in Year</label>
                <input type="number" name="experienceyear" id="job-experience-year" value="{{ $application->experienceyear }}">
                <div class="error" id="experienceyear-error"></div>
            </div>
            <div>
                <label for="job-previous">Previous Job Titles</label>
                <input type="text" id="job-previous" name="previousjob" value="{{ $application->previousjob }}">
                <div class="error" id="previousjob-error"></div>
            </div>
            <div>
                <label for="job-company">Previous Company Name</label>
                <input type="text" id="job-company" name="company" value="{{ $application->company }}">
                <div class="error" id="company-error"></div>
            </div>
            <div>
                <label for="job-Previous-salary">Previous Salary</label>
                <input type="text" name="previoussalary" id="job-previous-salary" value="{{ $application->previoussalary }}">
                <div class="error" id="previoussalary-error"></div>
            </div>

            <!-- Skills -->
            <div class="multi-value">
                <span>Relevant Skill</span>
                @php
                    $skills = explode(',', $application->skills ?? '');
                @endphp
                <label><input type="checkbox" name="skill" value="communication" {{ in_array('communication', $skills) ? 'checked' : '' }}> Communication</label>
                <label><input type="checkbox" name="skill" value="problemsolving" {{ in_array('problemsolving', $skills) ? 'checked' : '' }}> Problem Solving</label>
                <label><input type="checkbox" name="skill" value="leadership" {{ in_array('leadership', $skills) ? 'checked' : '' }}> Leadership</label>
                <label><input type="checkbox" name="skill" value="timemanagement" {{ in_array('timemanagement', $skills) ? 'checked' : '' }}> Time Management</label>
                <label><input type="checkbox" name="skill" value="dataanalysis" {{ in_array('dataanalysis', $skills) ? 'checked' : '' }}> Data Analysis</label>
                <label><input type="checkbox" name="skill" value="customerservice" {{ in_array('customerservice', $skills) ? 'checked' : '' }}> Customer Service</label>
                <div class="error" id="skill-error"></div>
            </div>
        </div>
    </fieldset>

    <!-- Job-Related Details -->
    <fieldset>
        <legend class="sub-title">Job-Related Details</legend>

        <div>
            <label for="job-position">Position Applying For</label>
            <select name="jobposition" id="job-position">
                <option disabled value="">Position</option>
                <option value="preojectmanager" {{ $application->jobposition == 'preojectmanager' ? 'selected' : '' }}>Project Manager</option>
                <option value="businessanalyst" {{ $application->jobposition == 'businessanalyst' ? 'selected' : '' }}>Business Analyst</option>
                <option value="marketingmanager" {{ $application->jobposition == 'marketingmanager' ? 'selected' : '' }}>Marketing Manager</option>
                <option value="seniordeveloper" {{ $application->jobposition == 'seniordeveloper' ? 'selected' : '' }}>Senior Developer</option>
            </select>
            <div class="error" id="jobposition-error"></div>
        </div>

        <div>
            <label for="job-location">Preferred Location</label>
            <select name="joblocation" id="job-location">
                <option disabled value="">Location</option>
                <option value="ahmedabad" {{ $application->joblocation == 'ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                <option value="pune" {{ $application->joblocation == 'pune' ? 'selected' : '' }}>Pune</option>
                <option value="delhi" {{ $application->joblocation == 'delhi' ? 'selected' : '' }}>Delhi</option>
                <option value="mumbai" {{ $application->joblocation == 'mumbai' ? 'selected' : '' }}>Mumbai</option>
            </select>
            <div class="error" id="joblocation-error"></div>
        </div>

        <div>
            <label for="start-date">Available Start Date</label>
            <input type="date" name="startdate" id="start-date" value="{{ $application->startdate }}">
            <div class="error" id="startdate-error"></div>
        </div>

        <div>
            <label for="job-expected-salary">Expected Salary</label>
            <input type="text" name="jobexpectedsalary" id="job-expected-salary" value="{{ $application->jobexpectedsalary }}" min="0" placeholder="10000">
            <div class="error" id="jobexpectedsalary-error"></div>
        </div>
    </fieldset>

    <!-- Upload Documents -->
        <fieldset>
        <legend class="sub-title">Upload Documents</legend>

        <div>
        <label>Current Resume</label><br>
        <a href="{{ asset('storage/'.$application->resume) }}" target="_blank">View Current Resume</a><br><br>

        <label>Upload new Resume (optional):</label>
        <input type="file"  id="resume" name="resume" accept=".pdf">
        <input type="hidden" name="old_resume" id="old_resume" value="{{ $application->resume }}">
        <div class="error" id="resume-error"></div>
        </div>

        <div>
            <label>Current Photo</label><br>
            <img src="{{ asset('storage/'.$application->photo) }}" width="120"><br><br>
            <label>Upload new Photo (optional):</label>
            <input type="file" id="photo" name="photo" accept="image/*">
            <input type="hidden" name="old_photo" id="old_photo" value="{{ $application->photo }}">
            <div class="error" id="photo-error"></div>
        </div>
    </fieldset>

    <!-- Form Buttons -->
    <div class="btn-handler">
        <div>
            <input type="submit" value="Submit" class="success-button">
            <input type="reset" onclick="removeError()" value="Reset" class="danger-button">
        </div>
        <a style="text-align:center" class="form-link" href='{{ route('home') }}'>Home</a>
    </div>

    <div id="toast" class="toast">Form submitted successfully!</div>
</form>

</body>

</html>