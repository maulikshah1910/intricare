<?php
return [
    'name' => 'Name',
    'email' => 'Email',
    'phone' => 'Phone',
    'gender' => 'Gender',
    'male' => 'Male',
    'female' => 'Female',
    'other' => 'Other',
    'image' => 'Image',
    'genders' => [
        'm' => 'Male',
        'f' => 'Female',
        'o' => 'Other',
        'male' => 'Male',
        'female' => 'Female',
        'other' => 'Other',
    ],
    'add' => 'Add',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'view' => 'View',
    'user' => 'User',
    'close' => 'Close',
    'save' => 'Save',
    'errors' => [
        'name' => [
            'required' => 'Please enter name',
        ],
        'email' => [
            'required' => 'Please enter email',
            'email' => 'Please enter valid email',
            'unique' => 'This email is already registered. Please enter another email',
        ],
        'phone' => [
            'required' => 'Please enter phone number',
            'digits' => 'Please enter valid phone number',
        ],
        'image' => [
            'image' => 'Please choose valid image'
        ]
    ],
    'save_success' => 'User info is saved successfully.',
    'delete_success' => 'User is removed successfully.',
    'not_found' => 'User not found...',
    'you_sure' => 'Are you sure?',
    'delete_confirm' => 'Are you sure to delete user details?',
    'yes' => 'Yes',
    'no' => 'No'
];
