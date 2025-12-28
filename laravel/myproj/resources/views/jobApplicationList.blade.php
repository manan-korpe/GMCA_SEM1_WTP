@extends('layouts.main')

@section('title', 'Application list')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/jobApplicationList.css') }}">
@endpush

@section('content')
<div class="container">

    <div class="right-buttons">
        <center>
        @if($applications->count() > 0)
        <a href="{{ route('jobApplication') }}" class="edit-btn btn">New Application</a>
        @endif
        <a href="{{ route('home') }}" class="delete-btn btn">Home</a>
    </center>
    </div>

    @if($applications->count() > 0)
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
            @foreach($applications as $app)
            <tr>
                <td>
                    <span class="table-label">ID:</span> 
                    <button class="id-btn" onclick="showDetails(
                        '{{ $app->id }}',
                        '{{ $app->fname }}',
                        '{{ $app->lname }}',
                        '{{ $app->dob }}',
                        '{{ $app->gender }}',
                        '{{ $app->marital }}',
                        '{{ $app->nationality }}',
                        '{{ $app->mobile }}',
                        '{{ $app->email }}',
                        `{{ addslashes($app->address) }}`,
                        '{{ $app->pincode }}',
                        '{{ $app->qualification }}',
                        '{{ $app->fieldofstudy }}',
                        '{{ $app->universityinstitutionname }}',
                        '{{ $app->experience }}',
                        '{{ $app->experienceyear }}',
                        '{{ $app->previousjob }}',
                        '{{ $app->company }}',
                        '{{ $app->previoussalary }}',
                        '{{ $app->skills }}',
                        '{{ $app->jobposition }}',
                        '{{ $app->joblocation }}',
                        '{{ $app->startdate }}',
                        '{{ $app->jobexpectedsalary }}',
                        '{{ asset('storage/'.$app->resume) }}',
                        '{{ asset('storage/'.$app->photo) }}'
                    )">{{ $app->id }}</button>
                </td>
                <td><img src="{{ asset('storage/'.$app->photo) }}" alt="Photo"></td>
                <td>{{ $app->fname }} {{ $app->lname }}</td>
                <td>{{ $app->email }}</td>
                <td>{{ $app->jobposition }}</td>
                <td><a href="{{ asset('storage/'.$app->resume) }}" target="_blank">View</a></td>
                <td><a class="edit-btn btn" href="{{ route('jobApplication.update', ['id'=>$app->id]) }}">Edit</a></td>
                <td>
                    <form action="{{ route('jobApplication.delete', $app->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn btn">Delete</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-applications">
        <center><p>No applications found.</p></center>
        <center><a href="{{ route('jobApplication') }}" class="edit-btn btn">New Application</a></center>
    </div>
    @endif
</div>

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
@endsection

@push('scripts')
    <script src="js/jobApplicationList.js"></script>
@endpush
