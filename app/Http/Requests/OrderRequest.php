<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize() {
        return true;
    }


    public function rules() {

        return [
            'email' => 'required|email',
            'phone' => 'required|regex:/[0-9+]/',
            'name' => 'required|min:1|max:255',
            'answer' => 'required|integer',
        ];
    }


    public function messages() {
        return [
            'email' => 'wrong email address ...',
            'phone' => 'wrong phone number ...',
            'name' => 'wrong name number ...',
            'answer' => 'wrong answer ...',
       ];
    }
}
