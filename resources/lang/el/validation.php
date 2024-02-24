<?php
// resources/lang/el/validation.php

return [
    'attributes' => [
        'email' => 'ηλεκτρονικό ταχυδρομείο',
        'password' => 'κωδικός πρόσβασης',
    ],
    'required' => 'Το πεδίο :attribute είναι υποχρεωτικό.',
    'unique' => 'Το :attribute χρησιμοποιείται ήδη.',
    'confirmed' => 'Το πεδίο επιβεβαίωσης :attribute δεν ταιριάζει.',
    'custom' => [
        'email' => [
            'unique' => 'Το :attribute χρησιμοποιείται ήδη.',
        ],
        'password' => [
            'confirmed' => 'Το πεδίο επιβεβαίωσης :attribute δεν ταιριάζει.',
        ],
        'email.exists' => 'Το :attribute δεν υπάρχει.',

        'job_title' => [
            'required' => 'Το πεδίο του τίτλου της εργασίας πρέπει να συμπληρωθεί.',
        ],
        'job_description' => [
            'required' => 'Το πεδίο της περιγραφής της εργασίας πρέπει να συμπληρωθεί.',
        ],
        'location' => [
            'required' => 'Το πεδίο της τοποθεσίας πρέπει να συμπληρωθεί.',
        ],
        'qualifications' => [
            'required' => 'Το πεδίο των προσόντων πρέπει να συμπληρωθεί.',
        ],
        'job_category_id' => [
            'required' => 'Το πεδίο της κατηγορίας εργασίας πρέπει να συμπληρωθεί.',
        ],

    ],
];
