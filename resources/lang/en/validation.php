<?php
// resources/lang/en/validation.php

return [
    'attributes' => [
        'email' => 'email',
        'password' => 'password',

    ],
    'required' => 'The :attribute field is required.',
    'unique' => 'The :attribute has already been taken.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'custom' => [
        'email' => [
            'unique' => 'The :attribute has already been taken.',
        ],
        'password' => [
            'confirmed' => 'The :attribute confirmation does not match.',
        ],
        'email.exists' => 'The selected :attribute is invalid.',

        'job_title' => [
            'required' => 'The :attribute field is required.',
        ],
        'job_description' => [
            'required' => 'The :attribute field is required.',
        ],
        'location' => [
            'required' => 'The :attribute field is required.',
        ],
        'qualifications' => [
            'required' => 'The :attribute field is required.',
        ],
        'job_category_id' => [
            'required' => 'The :attribute field is required.',
        ],
    ],
];
