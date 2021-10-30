<?php

/**
 * UserMapping for tests.
 */
return [
    'id' => [
        'column' => 'UserID'
    ],
    'firstname' => [
        'validation' => [
            'required',
            'size' => ['max' => 15]
        ]
    ],
    'lastname' => [],
    'hobbies' => [
        'form' => [
            'type' => 'textarea'
        ]
    ],
    'genderID' => [
        'column' => 'GenderID',
        'form' => [
            'type' => 'select',
            'options' => ['1' => 'male', '2' => 'female', '3' => 'other'],
            'label' => 'Choose gender'
        ]
    ],
    'Gender' => [
        'column' => 'GenderID',
        'type' => 'Gender',
        'form' => [
            'hidden' => true
        ]
    ]
];
