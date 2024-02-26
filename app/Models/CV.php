<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'phone_number',
        'proficiency',
        'description',
        'experience',
        'photo',
    ];

    protected $table = 'cvs';

    /**
     * get the user that owns the CV.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * accessor for getting the full URL of the photo.
     */
    public function getPhotoUrlAttribute()
    {
        return asset('storage/' . $this->photo);
    }
}
