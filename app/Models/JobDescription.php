<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDescription extends Model
{
    use HasFactory;

    protected $table = 'job_descriptions';

    protected $fillable = [
        'jobdescriptiongreek',
        'jobdescriptionenglish',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
