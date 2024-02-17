<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules():array
    {
        $rules = [
            'name' => 'required|min:5',
            'slogan' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required|starts_with:97,98|digits:10',
            'optional_email' => 'nullable|email|required_if:optional_email,null',
            'mobile' => 'required|starts_with:97,98|digits:10',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
        ];

        // Conditionally add image validation only for the create action
        if ($this->isMethod('post')) {
            $rules['logo_header_file'] = 'required';
            $rules['hero_image_file'] = 'required';
        }

        return $rules;
    }
    public function messages():array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Your name must be at least 5 characters long.',
            'slogan.required' => 'Slogan is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'address.required' => 'Address is required.',
            'phone.required' => 'Phone number is required.',
            'phone.starts_with' => 'Phone number must start with 97 or 98.',
            'phone.digits' => 'Phone number must be exactly 10 digits long.',
            'optional_email.required_if' => 'The optional email field is required when it is empty.',
            'optional_email.email' => 'The optional email field must be a valid email format.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.starts_with' => 'Mobile number must start with 97 or 98.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits long.',
            'meta_title.required' => 'Meta Title is required.',
            'meta_description.required' => 'Meta Description is required.',
            'meta_keyword.required' => 'Meta Keyword is required.',
        ];
    }
}
