<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $table = 'job_application';

    protected $fillable = [
        'user_id','fname','lname','dob','gender','marital','nationality',
        'mobile','email','address','pincode',
        'qualification','fieldofstudy','universityinstitutionname',
        'experience','experienceyear','previousjob','company','previoussalary','skills',
        'jobposition','joblocation','startdate','jobexpectedsalary',
        'resume','photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
