<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'job_description',
        'location',
        'qualifications',
        'job_category_id'
    ];

    // Define the relationship with recruiter
    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }

    // Define the relationship with job category
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }

    public function applicants()
    {
        return $this->belongsToMany(User::class, 'job_applications')->withTimestamps();
    }

    // Define the relationship with job applications
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_listing_id');
    }
}

