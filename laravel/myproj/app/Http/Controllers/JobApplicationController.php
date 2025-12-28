<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function showJobApplication()
    {
        return view('jobApplication');
    }

    public function listJobApplication()
    {
        $user_id = session('user_id');

        $applications = JobApplication::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();

        return view('jobApplicationList', compact('applications'));
    }

    public function submit(Request $request)
    {
        $user_id = session('user_id');
        // dd($request->all());
        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required',
            'marital' => 'required',
            'nationality' => 'required',

            'mobile' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'pincode' => 'required',

            'qualification' => 'required',
            'fieldofstudy' => 'required',
            'universityinstitutionname' => 'required',

            'experience' => 'string',
            'experienceyear' => 'string',
            'previousjob' => 'string',
            'company' => 'string',
            'previoussalary' => 'string',

            // 'skill' => 'string',

            'jobposition' => 'required',
            'joblocation' => 'required',
            'startdate' => 'required|date',
            'jobexpectedsalary' => 'required',

            'resume' => 'required|file',
            'photo' => 'required|image',
        ]);
        
        //    dd($request->all());
        $skills = $request->has('skill')
            ? implode(',', $request->skill)
            : null;

        $uploadPath = 'uploads';

        $resumeFile = time().$request->fname.'_resume_'.$request->file('resume')->getClientOriginalName();
        $resumePath = $request->file('resume')->storeAs($uploadPath, $resumeFile, 'public');

        $photoFile = time().$request->fname.'_photo_'.$request->file('photo')->getClientOriginalName();
        $photoPath = $request->file('photo')->storeAs($uploadPath, $photoFile, 'public');

     
        jobApplication::create([
            'user_id' => $user_id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'marital' => $request->marital,
            'nationality' => $request->nationality,

            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'pincode' => $request->pincode,

            'qualification' => $request->qualification,
            'fieldofstudy' => $request->fieldofstudy,
            'universityinstitutionname' => $request->universityinstitutionname,

            'experience' => $request->experience ?? 'fresher',
            'experienceyear' => $request->experienceyear,
            'previousjob' => $request->previousjob,
            'company' => $request->company,
            'previoussalary' => $request->previoussalary,
            'skills' => $skills,

            'jobposition' => $request->jobposition,
            'joblocation' => $request->joblocation,
            'startdate' => $request->startdate,
            'jobexpectedsalary' => $request->jobexpectedsalary,

            'resume' => $resumePath,
            'photo' => $photoPath,
        ]);

        return redirect()->route('home')
            ->with('toastMessage', 'Application successfully submitted!')
            ->with('toastType', 'success');
    }

    public function delete($id)
    {
        $user_id = session('user_id');

        $application = JobApplication::where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (! $application) {
            return redirect()->back()->with('toastMessage', 'Unauthorized action!')->with('toastType', 'error');
        }

        if ($application->resume && Storage::exists($application->resume)) {
            Storage::delete($application->resume);
        }

        if ($application->photo && Storage::exists($application->photo)) {
            Storage::delete($application->photo);
        }

        $application->delete();

        return redirect()->route('jobApplication.list')
            ->with('toastMessage', 'Application deleted successfully!')
            ->with('toastType', 'success');
    }

    public function showUpdate($id)
    {
        $user_id = session('user_id');
        $application = jobApplication::where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        return view('updateApplication', compact('application'));
    }

    public function update(Request $request, $id)
    {
        $user_id = session('user_id');

        // Find existing job application
        $jobApplication = jobApplication::where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (! $jobApplication) {
            return redirect()->back()
                ->with('toastMessage', 'Unauthorized to perform action!')
                ->with('toastType', 'error');
        }

        // Validate input
        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required',
            'marital' => 'required',
            'nationality' => 'required',

            'mobile' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'pincode' => 'required',

            'qualification' => 'required',
            'fieldofstudy' => 'required',
            'universityinstitutionname' => 'required',

            'experience' => 'nullable',
            'experienceyear' => 'nullable',
            'previousjob' => 'nullable',
            'company' => 'nullable',
            'previoussalary' => 'nullable',

            'skill' => 'nullable|array',

            'jobposition' => 'required',
            'joblocation' => 'required',
            'startdate' => 'required|date',
            'jobexpectedsalary' => 'required',

            'resume' => 'nullable|file',
            'photo' => 'nullable|image',
        ]);

        // Handle skills
        $skills = $request->has('skill') ? implode(',', $request->skill) : null;

        $uploadPath = 'uploads';

        // Handle resume upload
        if ($request->hasFile('resume')) {
            // Delete old file if exists
            if ($jobApplication->resume) {
                Storage::disk('public')->delete($jobApplication->resume);
            }
            $resumeFile = time().$request->fname.'_resume_'.$request->file('resume')->getClientOriginalName();
            $resumePath = $request->file('resume')->storeAs($uploadPath, $resumeFile, 'public');
        } else {
            $resumePath = $jobApplication->resume; // keep old
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($jobApplication->photo) {
                Storage::disk('public')->delete($jobApplication->photo);
            }
            $photoFile = time().$request->fname.'_photo_'.$request->file('photo')->getClientOriginalName();
            $photoPath = $request->file('photo')->storeAs($uploadPath, $photoFile, 'public');
        } else {
            $photoPath = $jobApplication->photo; // keep old
        }

        // Update the application
        $jobApplication->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'marital' => $request->marital,
            'nationality' => $request->nationality,

            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'pincode' => $request->pincode,

            'qualification' => $request->qualification,
            'fieldofstudy' => $request->fieldofstudy,
            'universityinstitutionname' => $request->universityinstitutionname,

            'experience' => $request->experience ?? 'fresher',
            'experienceyear' => $request->experienceyear,
            'previousjob' => $request->previousjob,
            'company' => $request->company,
            'previoussalary' => $request->previoussalary,
            'skills' => $skills,

            'jobposition' => $request->jobposition,
            'joblocation' => $request->joblocation,
            'startdate' => $request->startdate,
            'jobexpectedsalary' => $request->jobexpectedsalary,

            'resume' => $resumePath,
            'photo' => $photoPath,
        ]);

        return redirect()->route('jobApplication.list')
            ->with('toastMessage', 'Application successfully updated!')
            ->with('toastType', 'success');
    }
}
