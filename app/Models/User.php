<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class User extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'gender', 'phone', 'image'
    ];

    public static function validate($data)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10',
            'gender' => 'required',
            'image' => 'nullable|image'
        ];
        if (isset($data['id']) && $data['id'] > 0) {
            $rules['email'] = 'required|email|unique:users,email,' . $data['id'];
        }
        $messages = [
            'name.required' => trans('users.errors.name.required'),
            'email.required' => trans('users.errors.email.required'),
            'email.email' => trans('users.errors.email.email'),
            'email.unique' => trans('users.errors.email.unique'),
            'phone.required' => trans('users.errors.phone.required'),
            'phone.digits' => trans('users.errors.phone.digits'),
            'image.image' => trans('users.errors.image.image'),
        ];

        return Validator::make($data, $rules, $messages);
    }
}
