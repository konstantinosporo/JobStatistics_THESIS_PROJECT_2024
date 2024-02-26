<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    // constructor to automatically set the role
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->role = self::ROLE_ADMIN;
    }

}
