<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruiter extends User
{
    // Constructor to automatically set the role
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->role = self::ROLE_RECRUITER;
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class, 'recruiter_id');
    }
}
