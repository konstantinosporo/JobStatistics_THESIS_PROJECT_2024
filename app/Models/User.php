<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_RECRUITER = 'recruiter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isApplicant()
    {
        return $this->role === self::ROLE_USER;
    }

    public function isRecruiter()
    {
        return $this->role === self::ROLE_RECRUITER;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function cv()
    {
        return $this->hasOne(CV::class);
    }

    public function hasCv()
    {
        return $this->cv()->exists();
    }

    public function jobApplications()
    {
        return $this->belongsToMany(JobListing::class, 'job_applications', 'user_id', 'job_listing_id')->withTimestamps();
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class, 'recruiter_id');
    }

    public function userPreferences()
    {
        return $this->hasOne(UserPreferences::class);
    }

}
