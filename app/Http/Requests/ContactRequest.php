<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {

        return [
            'email' => 'required|email',
            'phone' => 'required|regex:/[0-9+]/',
            'name' => 'required|min:3|max:255',
            'comment' => 'required|min:10',
        ];
    }


    public function messages() {
        return [
            'email' => 'Invalid email address ...',
            'phone' => 'Invalid phone number ...',
            'name' => 'Wrong name ...',
            'comment' => 'Too short comment ...',
        ];
    }
}
