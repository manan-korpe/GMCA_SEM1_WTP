<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_application', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            // User
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');


            // Personal details
            $table->string('fname');
            $table->string('lname');
            $table->date('dob');
            $table->string('gender');
            $table->string('marital');
            $table->string('nationality');

            // Contact
            $table->string('mobile');
            $table->string('email');
            $table->text('address');
            $table->string('pincode');

            // Education
            $table->string('qualification');
            $table->string('fieldofstudy');
            $table->string('universityinstitutionname');

            // Experience
            $table->string('experience')->default('fresher');
            $table->string('experienceyear')->nullable();
            $table->string('previousjob')->nullable();
            $table->string('company')->nullable();
            $table->string('previoussalary')->nullable();

            // Skills
            $table->text('skills')->nullable();

            // Job details
            $table->string('jobposition');
            $table->string('joblocation');
            $table->date('startdate');
            $table->string('jobexpectedsalary');

            // Files
            $table->string('resume');
            $table->string('photo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_application');
    }
};
